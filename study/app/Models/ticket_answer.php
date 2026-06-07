<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ticket_answer extends Model
{
    protected $fillable = ['ticket_id','answer','User_id'];

    public function tickets()
    {
        return $this->belongsTo(ticket::class,'ticket_id');
    }
}
