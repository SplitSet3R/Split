<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedExpense extends Model
{
    public  $incrementing = false;
    public  $timestamps = false;
    protected $table = 'sharedexpenses';
    protected $fillable = [
        'expense_id', 'amount_owed', 'secondary_username', 'comments', 'date_added', 'date_settled'
    ];
}
