<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupSharedExpense extends Model
{
    protected $fillable = [
        'group_expense_id', 'username', 'amount_owed', 'comments','date_added'
    ];
    public $table = "groupsharedexpenses";
    public function groupExpense(){
        return $this->belongsTo('App\GroupExpense', 'group_expense_id');
    }
    public function groupSettledExpense(){
        return $this->hasOne('App\GroupSettledExpense');
    }
}
