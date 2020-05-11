<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body'
    ];

    /**
     * Define the relation between the user and the posts
     */
    public function user()
    {
        //The post belongs to a unique user
        return $this->belongsTo(User::class);
    }
}
