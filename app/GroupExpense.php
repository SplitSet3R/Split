<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupExpense extends Model
{
    public function Group(){
        return $this->belongsto('App\Group', 'group_id');
    }
}
