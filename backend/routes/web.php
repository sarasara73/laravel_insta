<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'can:admin', 'prefix' => 'admin'],function(){ //"can" is for Gate::
    #user
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users');


    Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('admin.users.deactivate'); //put timestamp
    Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('admin.users.activate'); //remove timestamp


    #post
    Route::get('/posts', [PostsController::class, 'index'])->name('admin.posts');
    Route::delete('/posts/{id}/hide', [PostsController::class, 'hide'])->name('admin.posts.hide');
    Route::patch('/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('admin.posts.unhide');

    #category
    Route::get('/categories', [CategoriesController::class, 'index'])->name('admin.categories');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::patch('/categories/{id}/update',[CategoriesController::class,'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}/destroy',[CategoriesController::class,'destroy'])->name('admin.destroy.update');

});

Route::group(['middleware' => 'auth'], function(){

    Route::get('/', [HomeController::class, 'index'])->name('index');

    #post
    Route::get('/post/create',[PostController::class,'create'])->name('post.create');
    Route::post('/post/store',[PostController::class,'store'])->name('post.store');
    Route::get('/post/{id}/show',[PostController::class,'show'])->name('post.show');
    Route::get('/post/{id}/edit',[PostController::class,'edit'])->name('post.edit');
    Route::patch('/post/{id}/update',[PostController::class,'update'])->name('post.update');
    Route::delete('/post/{id}/destroy',[PostController::class,'destroy'])->name('post.destroy');

    #comment
    Route::post('/comment/{post_id}/store',[CommentController::class,'store'])->name('comment.store');

    Route::delete('/comment/{id}/destroy',[CommentController::class,'destroy'])->name('comment.destroy');

    #profile
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/show/followers',[ProfileController::class,'followers'])->name('profile.followers');
    Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile/update', [Profilecontroller::class,'update'])->name('profile.update');

    #like
    Route::post('/like/{post_id}/store',[LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy',[LikeController::class,'destroy'])->name('like.destroy');

    #follow
    Route::post('/follow/{id}/store',[FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{id}/destroy',[FollowController::class,'destroy'])->name('follow.destroy');
});
