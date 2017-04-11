<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedExpense extends Model
{
    //public  $incrementing = false;
    public  $timestamps = false;
    protected $table = 'sharedexpenses';

    /**
     * Instantiates a new SharedExpense object
     * @return Expense
     */
    static public function createSharedExpense()
    {
        return new self();
    }

    public function withExpense($expense)
    {
        $this->expense_id = $expense;
        return $this;
    }

    public function withAmountOwed($amountOwed)
    {
        $this->amount_owed = $amountOwed;
        return $this;
    }

    public function withComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    public function withUserOwing($userOwing)
    {
        $this->secondary_username = $userOwing;
        return $this;
    }

    public function saveSharedExpense()
    {
        $this->save();
        return $this;
    }

}
