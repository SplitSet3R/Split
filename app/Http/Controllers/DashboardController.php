<?php
namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\CustomClasses\Notifications\ExpenseNotification;
use Illuminate\Http\Request;
use App\Expense;
use App\SharedExpense;
use App\User;
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

    public function getExpenses()
    {
      //user owns means the user paid and they're owed money
        $expensesWhereUserOwns = DB::table('expenses AS e')
            ->leftjoin('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->select('e.*', 'se.secondary_username', 'se.amount_owed')
            ->where('e.owner_username', Auth::user()->username);
        //dd($expensesWhereUserOwns->get());
        $allExpenses = DB::table('expenses AS e')
            ->join('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->select('e.*', 'se.secondary_username', 'se.amount_owed')
            ->where('se.secondary_username', Auth::user()->username)
            ->union($expensesWhereUserOwns)
            ->get();
        return $allExpenses;
    }

    public function getExpenseSummary($expenses) {
      //make an summary
      //return new
        $summary = array();
        $owed = DB::table('expenses AS e')
            ->join('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->select('se.amount_owed')
            ->where('e.owner_username', Auth::user()->username)
            //->get();
            ->sum('se.amount_owed');
        $owing = DB::table('expenses AS e')
            ->join('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->select('se.amount_owed')
            ->where('se.secondary_username', '=', Auth::user()->username)
            //->get();
            ->sum('se.amount_owed');
        // ttl means amount spent
            // assuming that means
        $ttl = DB::table('expenses')
            ->where('owner_username', '=', Auth::user()->username)
            //->get();
            ->sum('amount');
        //$bal = $owed - $ttl;
        $bal = $owed - $owing;
        $summary['owed'] = $owed;
        $summary['owing'] = $owing;
        $summary['ttl'] = $ttl;
        $summary['bal'] = $bal;
        //dd(Auth::user()->username);
        //dd($summary);

        return $summary;

    }

    public function getAllSharedExpenses() {
        $allSharedExpenses = SharedExpense::all();
        return $allSharedExpenses;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->getExpenses();
        $summary = $this->getExpenseSummary($expenses);
        $allSharedExpenses = $this->getAllSharedExpenses();
        //$summary =

        //return $summary;
         return view('dashboard', compact('expenses', 'summary', 'allSharedExpenses'));
    }
}
