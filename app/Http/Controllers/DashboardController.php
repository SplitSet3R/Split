<?php
namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function store(Request $req)
    {
        $this->validate($req, [
            'expAmount' => 'required|numeric|min:1',
            'expType' => 'required|max:255',
            'expDate' => 'required|date'
        ]);
        $newExpense = new Expense;
        $newExpense->owner_username= Auth::user()->username;
        $newExpense->amount=$req->expAmount;
        $newExpense->type=$req->expType;
        $newExpense->date_added=$req->expDate;
        $newExpense->comments=$req->expComments;

        // TODO Refactor to not save an expense row when shared expenses has errors
        if($newExpense->save()) {
            if(isset($req->username) || isset($req->expOwedAmount)) {

              // TODO Set comment to nullable in database
              $this->validate($req, [
                  'expOwedAmount'   => 'required|numeric|min:1',
                  'username'        => 'exists:users|required|max:255',
                  'expOwerComments' => 'required|max:255'
              ]);
              /*
              try {
                $secondary_username = User::findOrFail($req->username);
              } catch (ModelNotFoundException $e) {
                // TODO
                return redirect()->back()->with("errorUsername", "User entered does not exist in the database");
              }
              */
              $newSharedExpense = new SharedExpense;
              $newSharedExpense->expense_id=$newExpense->id;
              $newSharedExpense->amount_owed=$req->expOwedAmount;
              $newSharedExpense->comments=$req->expOwerComments;
              $newSharedExpense->secondary_username=$req->username;
              $newSharedExpense->save();
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
        //$friends = getFriends();
        return view('dashboard', compact('expenses'));
    }
}
