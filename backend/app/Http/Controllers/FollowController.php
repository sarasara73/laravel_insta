<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    public function store($id){
        $this->follow->follower_id = Auth::user()->id;
        $this->follow->following_id = $id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->follow->where('follower_id', Auth::user()->id)->where('following_id', $id)->delete();

        return redirect()->back();
    }
}
