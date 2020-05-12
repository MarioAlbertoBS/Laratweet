<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body'
    ];

    protected $appends = [
        'humanCreatedAt'
    ];

    /**
     * Define the relation between the user and the posts
     */
    public function user()
    {
        //The post belongs to a unique user
        return $this->belongsTo(User::class);
    }

    /**
     * Get a readable form to show when the post were created
     */
    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
