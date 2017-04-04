<?php
namespace App\Http\Controllers;
use App\CustomClasses\Notifications\ExpenseNotification;
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
        $this->validate($req, [
            'expAmount' => 'required|numeric',
            'expType' => 'required|max:255',
            'expDate' => 'required|date',
            'expComments' => 'nullable|max:255'
        ]);
        $newExpense = new Expense;
        $newExpense->owner_username= Auth::user()->username;
        $newExpense->amount=$req->expAmount;
        $newExpense->type=$req->expType;
        $newExpense->date=$req->expDate;
        $newExpense->comments=$req->expComments;
        if($newExpense->save()) {
            if(isset($req->expOwedAmount)&&isset($req->expOwerUsername)) {
                $this->validate($req, [
                    'expOwedAmount' => 'required|numeric',
                    'expOwerUsername' => 'required|max:255',
                    'expOwerComments' => 'nullable|max:255'
                ]);
                $newSharedExpense = new SharedExpense;
                $newSharedExpense->expense_id=$newExpense->id;
                $newSharedExpense->amount_owed=$req->expOwedAmount;
                $newSharedExpense->comments=$req->expOwerComments;
                $newSharedExpense->secondary_username=$req->expOwerUsername;
                if($newSharedExpense->save()) {
                    //ExpenseNotification::makeExpenseRequestNotification($newExpense, $newSharedExpense);
                }
            }
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
            ->where('se.secondary_username', Auth::user()->username)
            ->union($expensesWhereUserOwns)
            ->get();
        return $allExpenses;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->getExpenses();
        return view('dashboard', compact('expenses'));
    }
}
