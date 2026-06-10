<?php

// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with(['users', 'latestMessage.user'])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1)
            )
            ->get()
            ->map(function ($conv) {
                $conv->unread_count = $conv->messages()
                    ->where('user_id', '!=', auth()->id())
                    ->where('created_at', '>', $conv->pivot->last_read_at ?? '1970-01-01')
                    ->count();
                return $conv;
            });

        $users = User::where('id', '!=', auth()->id())->get();

        return view('chat.index', compact('conversations', 'users'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation); // یا دستی چک کن

        // mark as read
        $conversation->users()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now(),
        ]);

        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at','DESC')
            ->get();

        $participants = $conversation->users;
        $allUsers = User::where('id', '!=', auth()->id())->get();

        $conversations = auth()->user()->conversations()
            ->with(['users', 'latestMessage.user'])
            ->get();

        return view('chat.show', compact('conversation', 'messages', 'participants', 'allUsers', 'conversations'));
    }

    public function startDM(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        // چک کن DM قبلی وجود داره؟
        $existing = Conversation::where('type', 'dm')
            ->whereHas('users', fn($q) => $q->where('user_id', auth()->id()))
            ->whereHas('users', fn($q) => $q->where('user_id', $request->user_id))
            ->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing);
        }

        $conv = Conversation::create(['type' => 'dm']);
        $conv->users()->attach([auth()->id(), $request->user_id]);

        return redirect()->route('chat.show', $conv);
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $conv = Conversation::create([
            'type' => 'group',
            'name' => $request->name,
        ]);

        $members = array_merge($request->user_ids, [auth()->id()]);
        $conv->users()->attach($members);

        return redirect()->route('chat.show', $conv);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return response()->json([
            'id'         => $message->id,
            'body'       => $message->body,
            'user'       => auth()->user()->name,
            'avatar'     => $message->user->avatar,
            'created_at' => $message->created_at->format('H:i'),
            'is_mine'    => true,
        ]);
    }

    // Polling — فقط پیام‌های جدیدتر از after_id رو برمیگردونه
    public function poll(Request $request, Conversation $conversation)
    {
        $afterId = $request->integer('after_id', 0);

        $messages = $conversation->messages()
            ->with('user')
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'body'       => $m->body,
                'user'       => $m->user->name,
                'avatar'     => $m->user->avatar,
                'created_at' => $m->created_at->format('H:i'),
                'is_mine'    => $m->user_id === auth()->id(),
            ]);

        return response()->json($messages);
    }

    // کاربر هر 30 ثانیه ping میزنه
    public function onlinePing()
    {
        Cache::put('user-online-' . auth()->id(), true, now()->addMinutes(2));
        return response()->json(['ok' => true]);
    }

    // لیست آنلاین‌ها برای نمایش بالای صفحه
    public function onlineUsers()
    {
        $userId = auth()->id();
        $user   = auth()->user();

        // همون منطق index — unread به ازای هر کاربر
        $unreadPerUser = $user->conversations()
            ->with(['messages' => fn($q) => $q->where('user_id', '!=', $userId)])
            ->get()
            ->flatMap(function ($conv) use ($userId) {
                return $conv->messages
                    ->where('created_at', '>', $conv->pivot->last_read_at ?? '1970-01-01')
                    ->map(fn($m) => ['user_id' => $m->user_id]);
            })
            ->groupBy('user_id')
            ->map->count();

        $users = User::where('id', '!=', $userId)
            ->get()
            ->filter(fn($u) => Cache::has('user-online-' . $u->id));

        return response()->json(
            $users->map(fn($u) => [
                'name'         => $u->name,
                'avatar'       => $u->avatar,
                'unread_count' => $unreadPerUser[$u->id] ?? 0,
            ])->values()
        );
    }


}
