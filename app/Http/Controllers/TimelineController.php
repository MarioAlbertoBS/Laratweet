<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class TimelineController extends Controller
{
    public function index()
    {
        //Get the following users
        $following = Auth::user()->following;

        //Get the followers for this user
        $followers = Auth::user()->followers;
        return view('home', compact('following', 'followers'));
    }
}
