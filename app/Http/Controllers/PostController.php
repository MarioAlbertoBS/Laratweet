<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Create a new post in the database
     */
    public function create(Request $request, Post $post)
    {
        //Create a new post for the authenticated user
        $createdPost = $request->user()->posts()->create([
            'body' => $request->body
        ]);

        //Return response, retrive the newest post data with the correspondent user data
        return response()->json($post->with('user')->find($createdPost->id));
    }

    /**
     * Index page
     * Get all the user and following users posts
     */
    public function index(Request $request, Post $post)
    {
        //Retrieve all the current user posts, and the following users
        //pluck(users.id), removing the id from the collection
        //push($request->user()->id), adds the current user id to the collection, if is missing we will not get the current user posts
        //with('user'), get the user data, non only the post (like a join)
        $allPosts = $post->whereIn('user_id', $request->user()->following()->pluck('users.id')->push($request->user()->id))->with('user');
        
        //Get the posts
        //Get the first 10 more recent posts
        $posts = $allPosts->orderBy('created_at', 'desc')->take(10)->get();

        return response()->json([
            'posts' => $posts
        ]);
    }
}
