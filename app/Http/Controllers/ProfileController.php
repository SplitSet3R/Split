<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Friend;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        if ($friendship->count() == 0) {
            return 2;
        } else if ($friendship->first()->status_code == "pending") {
            return 1;
        } else if ($friendship->first()->status_code == "approved") {
            return 0;
        }
        return 3;
    }

    public function getSharedExpenses($profile_name){

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

/*        $sharedgroups = DB::table('groups AS g')
            ->join('groupmembers AS gm', 'g.id', '=', 'gm.group_id')
            ->select('g.id AS group_id', 'g.name AS group_name', 'g.description AS desc')
            ->whereIn('username', [Auth::user()->username, $profile_name])
            ->groupBy('g.id')
            ->having(DB::raw('COUNT(g.id) = 2'))
            ->get();*/
        //TODO: try to implement this without having the count in the SELECT
        return $sharedgroups;
    }

    /*
     * Default behaviour for visiting a profile. Profile_name variable
     * passed in URL.
     */
    public function index($profile_name) {
        $profile_name = trim($profile_name);
        if (Auth::user()->username == $profile_name) {
            return view('debug');
            // TODO: return own profile
        }
        $status = $this->friendCheck($profile_name);
        if($status == 0) {
            $sharedexpenses = $this->getSharedExpenses($profile_name);
            $sharedgroups = $this->getSharedGroups($profile_name);
            //$groupexpenses = $this->getGroupExpenses;
            //TODO: add querying of groups expenses, clarify with FE on how they want to display this
            return view('debug', compact('status', 'sharedgroups'));
        }

        return view('debug', compact('status'));
    }
}
