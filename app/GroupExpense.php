<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupExpense extends Model
{
    protected $fillable = [
        'group_id', 'amount', 'comments', 'date_added', 'date_settled'
    ];
    public $table = "groupexpenses";
    public function group(){
        return $this->belongsTo('App\Group', 'group_id');
    }
    public function groupSharedExpenses(){
        return $this->hasMany('App\GroupSharedExpense');
    }
}
