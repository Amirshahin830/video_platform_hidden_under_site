<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'thumbnail',
        'views',
        'duration',
        'status',
    ];

    protected $casts = [
        'views'    => 'integer',
        'duration' => 'integer',
    ];

    // رابطه با کاربر (صاحب ویدئو)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // رابطه با لایک‌ها
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // فقط لایک‌ها
    public function likesOnly(): HasMany
    {
        return $this->hasMany(Like::class)->where('type', 'like');
    }

    // فقط دیسلایک‌ها
    public function dislikes(): HasMany
    {
        return $this->hasMany(Like::class)->where('type', 'dislike');
    }

    // فقط ویدئوهای منتشرشده
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // تبدیل ثانیه به فرمت خوانا (مثلاً 125 → 2:05)
    public function getFormattedDurationAttribute(): string
    {
        $minutes = intdiv($this->duration, 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    // آدرس کامل thumbnail
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-thumbnail.jpg');
    }

    // آدرس کامل فایل ویدئو
    public function getVideoUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

}
