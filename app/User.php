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
     * Define the following relationship (who i am following)
     */
    public function following()
    {
        //The user can follow another user in the follows table
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');
    }

    /**
     * Define the followers relationship (who are following me)
     */
    public function followers()
    {
        //The user can be followed for another user in the follows table
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');
    }

    /**
     * Check if the user is not the same to avoid following itself
     */
    public function isNotTheUser(User $user)
    {
        return $this->id !== $user->id;
    }

    /**
     * Check if we are not already following the user
     */
    public function isFollowing(User $user)
    {
        //Check the follows table, will return 1 if we are following the give user
        return (bool) $this->following->where('id', $user->id)->count();
    }

    /**
     * Run the validations and check if we can follow the given user
     */
    public function canFollow(User $user)
    {
        if ($this->isNotTheUser($user)) {
            return !$this->isFollowing($user);
        }
        return false;
    }

    /**
     * Run the validations and check if we can unfollow the given user
     */
    public function canUnFollow(User $user)
    {
        //If we are following the user, we can unfollow
        return $this->isFollowing($user);
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
