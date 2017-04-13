<?php

namespace App\Http\Controllers;

use App\SettledExpense;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\SharedExpense;
use Carbon\Carbon;

class SettleExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /*
     * Takes a request to settle a shared expense.
     * Requires a POST variable for shared_expenses.id AS id.
     *
     */
    function settleSharedExpense(Request $req) {
        if(isset($req->id) && $this->owedUserCheck($req->id)) {
            //don't need to try-catch this, already checked in owedUserCheck()
            $sharedexpense = SharedExpense::findOrFail($req->id);
            $settledexpense = new SettledExpense;
            $settledexpense->expense_id = $sharedexpense->expense_id;
            $settledexpense->amount_owed = $sharedexpense->amount_owed;
            $settledexpense->secondary_username = $sharedexpense->secondary_username;
            $settledexpense->comments = $sharedexpense->comments;
            $settledexpense->date_added = $sharedexpense->date_added;
            $settledexpense->date_settled = Carbon::now()->toDateString();

            //no need for try-catch, id not specified will pick one that isn't used alrady
            $settledexpense->save();

            try {
                $sharedexpense->delete();
            } catch (QueryException $e) {
                return redirect()->back()->with("error", "shared expense could not be deleted");
            }
        }
    }

    /*
     * Checks to make sure that the person settling the expense is
     * the person being owed the initial expense.
     */
    function owedUserCheck($id) {
        try {
            $expenseid = SharedExpense::findOrFail($id)
                ->pluck('expense_id');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with("error", "expense not found with id: ". $id);
        }

        try {
            $owner_username = Expense::findOrFail($expenseid)
                ->pluck('owner_username');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with("error", "shared expense does not have an associated expense");
        }

        if($owner_username != Auth::username()) {
            return redirect()->back()->with("error", "Only the owner of the expense can settled the expense");
        }
        return true;

    }

    function settleGroupSharedExpense(Request $req) {

    }

    function settleGroupExpense(Request $req) {

    }
}
