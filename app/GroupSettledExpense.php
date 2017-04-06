<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupSettledExpense extends Model
{
    protected $fillable = [
        'group_shared_expense_id', 'username', 'amount_owed', 'comments', 'date_settled',
    ];
    public $table = "groupsettledexpenses";


}
