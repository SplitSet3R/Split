<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
     * Handles edit request for the user, does not allow changing of username.
     * If user tries to make a call to edit profile with a profile_name not matching the
     * name of the user authenticated as an error message can be accessed on the other side and a success message if it can
     *
     * FE Note: please check for @if(session('error')) to see if this is being thrown.
     *          please check for @if(session('success')) to see successful edit was made.
     */
    public function edit(Request $req) {
        if(isset($profile_name) && Auth::user()->username == $profile_name ) {
            try {
                $user = User::findOrFail(Auth::user()->username);
            } catch (ModelNotFoundException $e) {
                return redirect()->back()->with('error', 'no user found with this username');
            }
            if(isset($req->email))
                $user->email = $req->email;
            if(isset($req->firstname))
                $user->firstname = $req->firstname;
            if(isset($req->lastname))
                $user->lastname = $req->lastname;
            if(isset($req->bio))
                $user->bio = $req->bio;
            if(isset($req->avatar))
                $user->avatar = $req->avatar;
            $user->save();
            return redirect()->back()->with('success', 'success');
        } else {
            return redirect()->back()->with('error', 'error message');
        }
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
            return view('debug', compact('profile','status', 'owedexpenses', 'owingexpenses', 'sharedgroups'));
            //TODO: implement redirect to frontend, replace "debug" with whatever page.
        } else {
            return view('debug', compact('ststus'));
            //TODO: this should return to a view where a limited profile is shown displaying either pending or not friends
        }
    }
}
