<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table      = 'expenses';
    protected $primaryKey = 'id';

    /**
     * Method that returns the shared expenses from this expense
     * @return the shared expense from this expense.
     */
    public function sharedexpenses()
    {
        return $this->hasMany('App\SharedExpense', 'expense_id', 'id');
    }
}
