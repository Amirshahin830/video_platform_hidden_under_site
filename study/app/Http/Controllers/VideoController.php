<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideoQualities;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {

        if(Auth::check() && (Auth::user()->hasRole('viewer') || Auth::user()->hasRole('admin'))) {
            $videos = Video::with('user')
                ->withCount('likesOnly')
                ->published()
                ->latest()
                ->paginate(12);

            return view('videos.index', compact('videos'));
        }
        else
            return view('home');



    }

    public function show(Video $video)
    {
        if(Auth::user()->hasRole('viewer') || Auth::user()->hasRole('admin')) {
            $video->increment('views');

            $video->loadCount(['likesOnly', 'dislikes']);
            $video->load('user');

            // نقش لایک کاربر فعلی
            $userLike = null;
            if (auth()->check()) {
                $like = $video->likes()->where('user_id', auth()->id())->first();
                $userLike = $like?->type;
            }

            // ویدئوهای مرتبط
            $related = Video::with('user')
                ->published()
                ->where('id', '!=', $video->id)
                ->latest()
                ->limit(8)
                ->get();

            return view('videos.show', compact('video', 'userLike', 'related'));
        }
        else
            return view('home');
    }

    public function create()
    {
        if(Auth::user()->hasRole('viewer') || Auth::user()->hasRole('admin')) {
            return view('videos.create');
        }
        else
            return view('home');
    }

    public function store(Request $request)
    {
        if(Auth::user()->hasRole('viewer') || Auth::user()->hasRole('admin')) {
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'video' => ['required', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:4098000'],
                'thumbnail' => ['nullable', 'image', 'max:2048'],
                'duration' => ['nullable', 'integer'],
            ]);

            $filePath = $request->file('video')->store('videos', 'public');


            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }
            else {
                $videoFullPath = storage_path('app/public/' . $filePath);
                $thumbnailName = 'thumbnails/' . pathinfo($filePath, PATHINFO_FILENAME) . '.jpg';
                $thumbnailFullPath = storage_path('app/public/' . $thumbnailName);
                // مطمئن شو پوشه وجود داره
                if (!file_exists(dirname($thumbnailFullPath))) {
                    mkdir(dirname($thumbnailFullPath), 0755, true);
                }

                // گرفتن فریم از ثانیه اول
                $cmd = sprintf(
                    'ffmpeg -ss 00:00:01 -i %s -vframes 1 -vf "scale=480:-1" -q:v 10 %s 2>/dev/null',
                    escapeshellarg($videoFullPath),
                    escapeshellarg($thumbnailFullPath)
                );
                exec($cmd, $output, $returnCode);

                $thumbnailPath = ($returnCode === 0) ? $thumbnailName : null;
            }

              $video = Video::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $filePath,
                'thumbnail' => $thumbnailPath,
                'duration' => $request->duration ?? 0,
                'status' => 'published',
            ]);
            ProcessVideoQualities::dispatch($video);

            return redirect()->route('home')->with('success', 'ویدئو با موفقیت آپلود شد.');
        }
        else
            return view('home');
    }

    public function like(Request $request, Video $video)
    {
        if(Auth::user()->hasRole('viewer') || Auth::user()->hasRole('admin')) {
            $request->validate([
                'type' => ['required', 'in:like,dislike'],
            ]);

            $existing = $video->likes()->where('user_id', auth()->id())->first();

            if ($existing) {
                if ($existing->type === $request->type) {
                    // دوباره همون رو زد — حذف کن (toggle)
                    $existing->delete();
                } else {
                    // تغییر از like به dislike یا برعکس
                    $existing->update(['type' => $request->type]);
                }
            } else {
                $video->likes()->create([
                    'user_id' => auth()->id(),
                    'type' => $request->type,
                ]);
            }

            return back();
        }
        else
            return view('home');
    }

    public function destroy(Video $video)
    {
        if(Auth::user()->hasRole('viewer') || Auth::user()->hasRole('admin')) {

            if ($video->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
                abort(403);
            }

            \Storage::disk('public')->delete($video->file_path);
            if ($video->thumbnail) {
                \Storage::disk('public')->delete($video->thumbnail);
            }

            $video->delete();

            return redirect()->route('home')->with('success', 'ویدئو حذف شد.');
        }
        else
            return view('home');
    }
}
