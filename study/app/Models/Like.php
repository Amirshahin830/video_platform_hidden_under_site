<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'video_id',
        'type',
    ];

    // رابطه با کاربر
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // رابطه با ویدئو
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
