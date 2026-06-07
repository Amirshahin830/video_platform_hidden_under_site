<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ticket_subject extends Model
{
    protected $fillable = ['subject'];
    public $timestamps = false ;
    public function tickets()
    {
        return $this->hasMany(ticket::class,'subject');
    }
}
