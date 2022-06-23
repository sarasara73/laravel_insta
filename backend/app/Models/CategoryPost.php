<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Post;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post'; //category model = category table
    protected $fillable = ['category_id', 'post_id'];
    public $timestamps = false; //laravel won't insert it

    #connection to categories table
    public function category(){
        return $this->belongsTo(Category::class);
    }

    #Connection to posts table
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
