<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'username';

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
    public function allFriends()
    {
        return $this->belongsToMany('App\User', 'friends', 'username1', 'username2');
    }

    /**
     * Method that returns all accepted friends of user.
     * @return  all accepted friends of user
     */
    public function acceptedFriends()
    {
        return $this->belongsToMany('App\User', 'friends', 'username1', 'username2')
                    ->wherePivot('status_code', '=', 'accepted');
    }
}
