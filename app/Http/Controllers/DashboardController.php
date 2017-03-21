<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\SharedExpense;
use DB;
use Auth;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $req)
    {
        $newExpense = new Expense;
        /*TODO Set name of owner to not hardcoded*/
        $newExpense->owner_username= Auth::user()->username;
        $newExpense->amount=$req->expAmount;
        $newExpense->type=$req->expType;
        $newExpense->date=$req->expDate;
        $newExpense->comments=$req->expComments;
        $newExpense->save();
        if(isset($req->expOwedAmount)&&isset($req->expOwerUsername)) {
            $newSharedExpense = new SharedExpense;
            $newSharedExpense->expense_id=$this->getMostRecentExpenseId();
            $newSharedExpense->amount_owed=$req->expOwedAmount;
            $newSharedExpense->comments=$req->expOwerComments;
            $newSharedExpense->secondary_username=$req->expOwerUsername;
            $newSharedExpense->save();
        }
        return redirect()->action('DashboardController@index');
    }

    public function getExpenses()
    {
        $expensesWhereUserOwns = DB::table('expenses AS e')
            ->leftjoin('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->select('e.*', 'se.secondary_username', 'se.amount_owed')
            ->where('e.owner_username', Auth::user()->username);
        $allExpenses = DB::table('expenses AS e')
            ->join('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->select('e.*', 'se.secondary_username', 'se.amount_owed')
            //TODO Change to not hard coding
            ->where('se.secondary_username', Auth::user()->username)
            ->union($expensesWhereUserOwns)
            ->get();
        return $allExpenses;
    }

    public function getFriends()
    {

    }

    public function getMostRecentExpenseId()
    {
        return DB::table('expenses')->select('expense_id')->orderBy('expense_id', 'DESC')->first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->getExpenses();
        //$friends = getFriends();
        return view('dashboard', compact('expenses'));
    }
}
