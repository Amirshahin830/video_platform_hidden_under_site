<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    protected $fillable = ['subject','phone_number','email','Description','type'];

    public function ticket_subject(){
        return $this->belongsTo(ticket_subject::class,'subject');
    }

    public function ticket_answers()
    {
        return $this->hasMany(ticket_answer::class);
    }
}
