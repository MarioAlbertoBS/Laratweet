<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $appends = ['avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define relation between the users and the posts
     */
    public function posts()
    {
        //The user can have many posts
        return $this->hasMany(Post::class);
    }

    /**
     * Return avatar image url
     */
    public function getAvatar()
    {
        return 'https://gravatar.com/avatar/'.md5($this->email).'/?s=45&d=mm';
    }

    /**
     * Return an avatar attribute
     */
    public function getAvatarAttribute()
    {
        return $this->getAvatar();
    }

    /**
     * Set the default keyname for queries
     */
    public function getRouteKeyName()
    {
        return 'username';
    }
}
