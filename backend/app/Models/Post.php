<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\CategoryPost;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    #post belongs to a user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
        //even if user is trashed we can still see him
    }

    #post --> CategoryPost
    public function categoryPost(){
        return $this->hasMany(categoryPost::class);
    }

    #post has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    #post has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    #returns true if the post is already liked
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
