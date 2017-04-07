<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public  $timestamps = false;

    /**
     * Method that returns the owner of the expense
     * @return owner of the expense
     */
    public function expenseOwner()
    {
        return $this->belongsTo('App\User', 'owner_username');
    }

    /**
     * Method that returns the shared expenses from this expense
     * @return the shared expense from this expense.
     */
    public function sharedexpenses()
    {
        return $this->hasMany('App\SharedExpense', 'expense_id', 'id');
    }

    /**
     * Instantiates a new Expense object
     * @return Expense
     */
    static public function createExpense()
    {
        return new self();
    }

    public function withExpenseOwner($owner)
    {
        $this->owner_username = $owner;
        return $this;
    }

    public function withExpenseAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function withType($expType)
    {
        $this->type = $expType;
        return $this;
    }

    public function withDate($expDate)
    {
        $this->date = $expDate;
        return $this;
    }

    public function withComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    public function saveExpense()
    {
        $this->save();
        return $this;
    }
}
