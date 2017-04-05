<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettledExpense extends Model
{
    public  $incrementing = false;
    public  $timestamps = false;
    protected $table = 'settledexpenses';
}
