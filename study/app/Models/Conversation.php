<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Conversation.php
class Conversation extends Model
{
    protected $fillable = ['name', 'type'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // اگه DM بود، طرف مقابل رو برمیگردونه
    public function otherUser()
    {
        return $this->users()->where('user_id', '!=', auth()->id())->first();
    }
}
