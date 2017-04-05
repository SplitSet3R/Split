<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    public  $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groupmembers';

    protected $fillable = [
        'group_id'
        ,'username'
        ,'status_code'
        ,'action_group_id'
        ,'is_Admin'
    ];
}
