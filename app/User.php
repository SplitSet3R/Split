<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table        = 'users';
    protected $primaryKey   = 'username';
    public    $incrementing = false;
    public    $timestamps   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'username', 'firstname', 'lastname', 'email', 'password', 'bio', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Method that returns the owned expenses by the user
     * @return the expenses owned by the user
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense', 'owner_username', 'username');
    }

    /**
     * Method that returns the groups where the user is a member of
     * @return the groups of user
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'groupmembers', 'username', 'group_id');
    }

    /**
     * Method that returns all friends of user regardless of the status code.
     * @return  all friends of user
     */
    public function allRelatedUsers()
    {
        $foundInUser1 =  $this->belongsToMany('App\User', 'friends', 'username1', 'username2')->get();
        $foundInUser2 =  $this->belongsToMany('App\User', 'friends', 'username2', 'username1')->get();

        $merged = $foundInUser1->merge($foundInUser2);
        return $merged;
    }

    /**
     * Method that returns all accepted friends of user.
     * @return  all accepted friends of user
     */

    public function acceptedFriends()
    {
        $foundInUser2 = $this->belongsToMany('App\User', 'friends', 'username2', 'username1')
            ->wherePivot('status_code', '=', 'accepted')->get();
        $foundInUser1 = $this->belongsToMany('App\User', 'friends', 'username1', 'username2')
                             ->wherePivot('status_code', '=', 'accepted')->get();

        $merged = $foundInUser1->merge($foundInUser2);
        return $merged;

    }

    /**
     * method returns all friend requests sent to the user that have not been accepted
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendsRequests()
    {
        return $this->belongsToMany('App\User', 'friends', 'username2', 'username1')
                              ->wherePivot('status_code', '=', 'pending')
                              ->wherePivot('action_username', '!=', $this->username)->get();
    }
}
