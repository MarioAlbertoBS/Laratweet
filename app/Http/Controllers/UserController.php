<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * User profile index page
     */
    public function index(User $user)
    {
        return view('users.index', compact('user'));
    }

    /**
     * Find a user
     */
    public function findByName(Request $request)
    {
        $users = User::where('username', 'LIKE', '%' . $request->user . '%')->get();
        return view('users.search', compact('users'));
    }

    /**
     * Follows an user
     */
    public function follow(Request $request, User $user)
    {
        //$request->user(), the authenticated user
        //$user, the user we are trying to follow
        if ($request->user()->canFollow($user)) {
            $request->user()->following()->attach($user->id);
        }
        return redirect('/users/'.$user->username);
    }

    /**
     * Unfollows the user
     */
    public function unFollow(Request $request, User $user)
    {
        //$request->user(), the authenticated user
        //$user, the user we are trying to follow
        if ($request->user()->canUnFollow($user)) {
            $request->user()->following()->detach($user->id);
        }
        return redirect('/users/'.$user->username);
    }
}
