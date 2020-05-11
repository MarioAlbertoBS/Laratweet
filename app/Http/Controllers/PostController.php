<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function create(Request $request, Post $post)
    {
        //Create a new post for the authenticated user
        $createdPost = $request->user()->posts()->create([
            'body' => $request->body
        ]);

        //Return response, retrive the newest post data with the correspondent user data
        return response()->json($post->with('user')->find($createdPost->id));
    }
}
