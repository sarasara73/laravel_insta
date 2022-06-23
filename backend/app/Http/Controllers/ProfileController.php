<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\User;

class ProfileController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/avatars/';
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return view('users.profile.show')->with('user', $user);
    }

    public function followers($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);

        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50'. Rule::unique('users')->ignore(Auth::user()->id),
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'intro' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->intro;

        #if the user uploads an avatar...
        if ($request->avatar){
            if($user->avatar){
                $this->deleteAvatar($user->avatar);
            }

            $user->avatar = $this->saveAvatar($request);
        }

        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    private function deleteAvatar($avatar_name)
    {
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;
        //avatar_path = public/avatars/16926762.jpeg

        if(Storage::disk('local')->exists($avatar_path)){
            Storage::disk('local')->delete($avatar_path);
        } //add illuminate facades storage
    }

    private function saveAvatar($request)
    {
        #rename the avatar to the current time to avoid overwriting
        $avatar_name = time().".". $request->avatar->extension();

        #save the avatar inside storate/app/public/avatars/
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }
}
