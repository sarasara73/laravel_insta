<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){
        $request->validate(
        [
            'comment_body'. $post_id => 'required|max:150'
        ],
        [
            'comment_body'. $post_id .'.required' => 'Cannnot submit an empty comment.',
            'comment_body'. $post_id .'.max' => 'The comment must not be greater than 150 characters.'
        ]);

        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->body = $request->input('comment_body'. $post_id);
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id){
        // $this->comment->findOrFail($id)->delete();
        //$comment = $this->comment->findOrFail($id)->delete;
        //$this->comment->where('id', $id)->delete();
          // $comment->delete();
        $this->comment->destroy($id); //destroy()is an eloquent, limited to primary;
        return redirect()->back();
    }
}
