<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Friend;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Returns user's info based on the profile name specified in the URL
     */
    public function getProfile($profile_name) {
        return User::find($profile_name);
    }

    /*
     * Checks for the friend status between the authenticated user
     * and the profile_name specified in the url.
     *
     * Returns:
     * 0 if they are friends
     * 1 if friend request is pending
     * 2 if they are not friends
     * 3 if some major error has occured
     */
    public function friendCheck($profile_name) {
        $friendship = Friend::whereIn('username1', [Auth::user()->username, $profile_name])
            ->whereIn('username2', [Auth::user()->username, $profile_name])
            ->where('status_code', 'approved')->get();
        //what if username1 == username2? this shouldn't happen but is a possibility.
        if ($friendship->count() == 0) {
            return config('constants.NOT_FRIENDS');
        } else if ($friendship->first()->status_code == "pending") {
            return config('constants.PENDING');
        } else if ($friendship->first()->status_code == "approved") {
            return config('constants.FRIENDS');
        }
        return config('constants.PROFILE_ERROR');
    }

    /*
     * Gets shared groups between users. Don't use $sharedgroups->two_members.
     */
    public function getSharedGroups($profile_name){
        $sharedgroups = DB::table('groups AS g')
            ->join('groupmembers AS gm', 'g.id', '=', 'gm.group_id')
            ->select('g.id AS group_id', 'g.name AS group_name', 'g.description AS desc', DB::raw('COUNT(gm.username) AS two_members'))
            ->whereIn('username', [Auth::user()->username, $profile_name])
            ->groupBy('g.id')
            ->having('two_members', '=', '2')
            ->get();
        //TODO: try to implement this without having the count in the SELECT
        //(Intersect and DB::raw in the where() don't work
        return $sharedgroups;
    }

    /*
     * Queries shared expenses table and returns expenses
     * owed to the person who's profile the user is visiting
     */
    public function getOwedExpenses($profile_name) {
        $owedexpenses = DB::table('expenses AS e')
            ->join('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->where('e.owner_username', Auth::user()->username)
            ->where('se.secondary_username', $profile_name)
            ->select('se.amount_owed AS amount',
                'e.type AS type',
                'se.comments AS comments',
                'se.date_added AS date_added',
                'se.date_settled AS date_settled')
            ->get();
        return $owedexpenses;
    }

    /*
    * Queries shared expenses table and returns expenses
    * owed to the person who's profile the user is visiting
    */
    public function getOwingExpenses($profile_name) {
        $owingexpenses = DB::table('expenses AS e')
            ->join('sharedexpenses AS se', 'e.id', '=', 'se.expense_id')
            ->where('e.owner_username', $profile_name)
            ->where('se.secondary_username', Auth::user()->username)
            ->select('se.amount_owed AS amount',
                'e.type AS type',
                'se.comments AS comments',
                'se.date_added AS date_added',
                'se.date_settled AS date_settled')
            ->get();
        return $owingexpenses;
    }

    /*
     * Default behaviour for visiting a profile. Profile_name variable
     * passed in URL.
     */
    public function index($profile_name) {
        $profile_name = trim($profile_name);
        if (Auth::user()->username == $profile_name) {
            // TODO: return own profile - DONE
            return view('profile');
        }
        $status = $this->friendCheck($profile_name);
        if($status == config('constants.FRIENDS')) {
            $profile = $this->getProfile($profile_name);
            $owedexpenses = $this->getOwedExpenses($profile_name);
            $owingexpenses = $this->getOwingExpenses($profile_name);
            $sharedgroups = $this->getSharedGroups($profile_name);
            //return view('debug', compact('profile','status', 'owedexpenses', 'owingexpenses', 'sharedgroups'));

            //TODO: implement redirect to frontend, replace "debug" with whatever page.
        } else {
            return view('debug', compact('ststus'));
            //TODO: this should return to a view where a limited profile is shown displaying either pending or not friends
        }


    }

    public function userProfile(){
        return view('userProfile');

    }
}
