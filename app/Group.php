<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    /**
     * Method that returns the members of this group.
     * @return members of this group
     */
    public function members()
    {
        return $this->belongsToMany('App\User', 'groupmembers', 'group_id', 'username');
    }
}
