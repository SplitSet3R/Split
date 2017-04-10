<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2017-04-06
 * Time: 9:41 PM
 */

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\CustomClasses\Notifications\ExpenseNotification;
use Illuminate\Http\Request;
use App\Expense;
use App\SharedExpense;
use App\User;
use DB;
use Auth;
use Validator;


class ExpenseController extends Controller
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

    /**
     * This adds an expense to the authenticated user
     */
    public function addExpense(Request $req)
    {
        DB::beginTransaction();

        $this->validate($req, [
            'expAmount' => 'required|numeric|min:1',
            'expType'   => 'required|max:255',
            'expDate'   => 'required|date'
        ]);

        $newExpense = Expense::createExpense()->withExpenseOwner(Auth::user()->username)
                                              ->withExpenseAmount($req->expAmount)
                                              ->withType($req->expType)
                                              ->withDate($req->expDate)
                                              ->withComments($req->expComments)
                                              ->saveExpense();

        if(isset($req->username) || isset($req->expOwedAmount))
        {

            $validateSharedExpense = Validator::make($req->all(), [
                'expOwedAmount'   => 'required|numeric|min:1|max:' . $newExpense->amount,
                'username'        => 'exists:users|required|max:255'
            ]);

            if ($validateSharedExpense->fails())
            {
                DB::rollBack();
                return back()->withErrors($validateSharedExpense);
            }

             SharedExpense::createSharedExpense()->withExpense($newExpense->id)
                                                 ->withAmountOwed($req->expOwedAmount)
                                                 ->withComments($req->expOwerComments)
                                                 ->withUserOwing($req->username)
                                                 ->saveSharedExpense();
        }

        DB::commit();

        return redirect()->action('DashboardController@index');
    }
}