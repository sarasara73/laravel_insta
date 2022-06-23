<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    public $timestamps = false;

    #like belongs to a user
    public function user(){
        return $this->belongsTo(User::class);
    }

    #like belongs to a post
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
