<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessVideoQualities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600;

    public function __construct(public Video $video) {}

    public function handle(): void
    {
        $this->video->update(['processing_status' => 'processing']);

        $inputPath = storage_path('app/public/' . $this->video->file_path);
        $baseName = pathinfo($this->video->file_path, PATHINFO_FILENAME);

        // بررسی رزولوشن ویدیوی اصلی
        $probeCmd = sprintf(
            'ffprobe -v error -select_streams v:0 -show_entries stream=height -of csv=p=0 %s',
            escapeshellarg($inputPath)
        );
        exec($probeCmd, $probeOutput);
        $originalHeight = (int)($probeOutput[0] ?? 0);

        $paths = [];

        // همیشه 360p میسازه
        $output360 = storage_path("app/public/videos/{$baseName}_360p.mp4");
        $cmd = sprintf(
            'ffmpeg -i %s -vf "scale=640:360:force_original_aspect_ratio=decrease,pad=640:360:(ow-iw)/2:(oh-ih)/2" -b:v 800k -c:v libx264 -c:a aac -movflags +faststart %s 2>&1',
            escapeshellarg($inputPath),
            escapeshellarg($output360)
        );
        exec($cmd, $o, $rc);
        \Log::info('ffmpeg output: ' . implode("\n", $o));
        \Log::info('ffmpeg return code: ' . $rc);
        \Log::info('input exists: ' . (file_exists($inputPath) ? 'yes' : 'no'));
        if ($rc === 0) $paths['path_360p'] = "videos/{$baseName}_360p.mp4";

        // اگه بالاتر از 360p بود، نسخه اصلی رو هم نگه میداره
        if ($originalHeight > 360) {
            $paths['path_original'] = $this->video->file_path;
        }

        if (empty($paths)) {
            $this->video->update(['processing_status' => 'failed']);
            return;
        }

        $this->video->update(array_merge($paths, ['processing_status' => 'done']));
    }
}
