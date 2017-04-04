<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupExpense extends Model
{
    public function group(){
        return $this->belongsTo('App\Group', 'group_id');
    }
}
