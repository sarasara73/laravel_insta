<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        //get all the users from the users table then pass the result to index.blade
        $all_users = $this->user->withTrashed()->latest()->paginate(10); //paginate sets the limit
        //withTrashed(): include soft deleted records in a query's result
        return view('admin.users.index')->with('all_users', $all_users);
    }

    public function deactivate($id)
    {
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id)
    {
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
        //onlyTrashed(): retrieves the soft deleted models only
        //restore(): un-delete a soft deleted model
    }
}
