<?php
namespace App\Http\Controllers;
use App\CustomClasses\Notifications\ExpenseNotification;
use App\CustomClasses\Notifications\FriendNotification;
use App\CustomClasses\Notifications\NotificationCategoryEnum;
use App\CustomClasses\Notifications\NotificationTypeEnum;
use Illuminate\Http\Request;
use App\Expense;
use App\Notification;
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
                    $this->makeExpenseRequestNotification($newExpense, $newSharedExpense);
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
    
    public function getFriends()
    {
    }

    /**
     * Generate an expense request notification.
     * @param Expense $expense
     * @param Expense $sharedExpense
     */
    public function makeExpenseRequestNotification(Expense $expense, Expense $sharedExpense)
    {
        $notification = new Notification;
        $notification->recipient_username = $sharedExpense->secondary_username;
        $notification->sender_username = $expense->owner_username;
        $notification->category = NotificationCategoryEnum::EXPENSE;
        $notification->type = NotificationTypeEnum::REQUEST;
        $notification->parameters = $sharedExpense->amount_owed;
        $notification->reference_id = $sharedExpense->id;
        $notification->save();
    }

    /**
     * Get notifications where user is the recipient of the friend request.
     * @return an array of arrays. Each sub array contains 1. Notification object, 2. Notification message (string)
     */
    public function getFriendNotifications()
    {
        $requests = DB::table('notifications')
            ->where('recipient_username', Auth::user()->username)
            ->where('category', 2) //category 2 is for just Friend notifications
            ->where('type', 1) //Just request notifications
            ->orderBy('is_read', 'ASC')
            ->get();
        $notifications = array();
        foreach($requests as $request)
        {
            $n = new FriendNotification($request->recipient_username,
                $request->sender_username,
                $request->category, $request->type,
                $request->parameters, $request->reference_id);

            $notification = array($n, $n->messageForNotification($n));
            array_push($notifications, $notification);
        }
        return $notifications;
    }

    /**
     * Get expense request notifications where the user is the recipient.
     * @return array holding subarrays of 1. Notification object, 2. Notification message as string
     */
    public function getExpenseNotifications()
    {
        $requests = DB::table('notifications')
        ->where('recipient_username', Auth::user()->username)
        ->where('category', 1) //only expense notifications
        ->where('type', 1) //only requests -- uncomment for all types
        ->orderBy('is_read', 'ASC')
        ->get();
        $notifications = array();
        foreach($requests as $request) {
            $n = new ExpenseNotification($request->recipient_username,
                $request->sender_username,
                $request->category,
                $request->type,
                $request->parameters,
                $request->reference_id);
            $notification = array($n, $n->messageForNotification($n));
            array_push($notifications, $notification);
        }
        return $notifications;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->getExpenses();
        $friendNotifications = $this->getFriendNotifications();
        $expenseNotifications = $this->getExpenseNotifications();
        return view('dashboard', compact('expenses', 'friendNotifications', 'expenseNotifications'));
    }
}
