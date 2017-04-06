<?php

namespace App\Http\Controllers;

use App\GroupExpense;
use App\GroupSettledExpense;
use App\GroupSharedExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GroupProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //returns group expenses for a group
    public function index(Group $group)
    {
        $groupExpenses = $group->groupExpenses;
        return view('groupProfile', compact('groupExpenses'));
    }
    //returns group shared expenses for a specific group expense
    public function getSharedExpensesForGroupExpense(GroupExpense $groupExpense){
        $groupSharedExpenses = $groupExpense->groupSharedExpenses;
        return $groupSharedExpenses;
    }
    //returns settled expense for group shared expense
    public function getSettledExpenseForSharedExpense(GroupSharedExpense $groupSharedExpense){
        $groupSettledExpenses = $groupSharedExpense->groupSettledExpense;
        return $groupSettledExpenses;
    }
    //create a group expense for a group
    public function createGroupExpense(array $data){
        return GroupExpense::create([
            'group_id' => $data['group_id'],
            'amount' => $data['amount'],
            'comments' => $data['comments'],
            'date_added' => $data['date_added'],
            'date_settled' => $data['date_settled'],
        ]);
    }
    //create shared group expense for a group expense
    public function createGroupSharedExpense(array $data){
        return GroupSharedExpense::create([
            'group_expense_id' => $data['group_expense_id'],
            'username' => $data['username'],
            'amount_owed' => $data['amount_owed'],
            'comments' => $data['comments'],
            'date_added' => $data['date_added'],
        ]);
    }
    //create a settled group expense for a shared group expense
    public function createGroupSettledExpense(array $data){
        return GroupSettledExpense::create([
            'group_shared_expense_id' => $data['group_shared_expense_id'],
            'username' => $data['username'],
            'amount_owed' => $data['amount_owed'],
            'comments' => $data['comments'],
            'date_settled' => $data['date_settled'],
        ]);
    }
}
