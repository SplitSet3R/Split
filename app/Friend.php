<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'username1', 'username2', 'lastname', 'status_code', 'action_username'
    ];
}
