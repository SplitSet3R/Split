<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    /*
     * AJAX Request to handle adding a friend specified in the request
     * conducted by the user currently authenticated
     */
    public function addfriend(Request $req) {
        if ($req->json() && isset($req->username)) {
            $friendstatus = Friend::whereIn('username1', [Auth::user()->username, $req->username])
                ->whereIn('username2', [Auth::user()->username, $req->username])
                ->count();
            if ($friendstatus < 1) { // Authenticated user is not friends with $req->username
                $friendship = new Friend;
                $friendship->username1 = Auth::user()->username;
                $friendship->username2 = $req->username;
                $friendship->status_code = 'pending';
                $friendship->action_username = Auth::user()->username;
                $friendship->save();
                return response()->json(array("message" => "friend request sent!"), 200);
            }
        }
        return response()->json(array("message" => "generic error message"), 500);
    }

    /*
     * AJAX Request to handle accepting/declining a friend request
     *
     */
    public function processFriendRequest(Request $req) {
        if ($req->json() && isset ($req->username)) {
            $friendship = Friend::whereIn('username1', [Auth::user()->username, $req->username])
                ->whereIn('username2', [Auth::user()->username, $req->username])
                ->where('status_code', 'pending');
            if (isset ($req->accepted)) {
                if ($req->accepted == 'accepted') {
                    $friendship->status_code = 'accepted';
                } else if ($req->accepted == 'denied') {
                    $friendship->statuts_code = 'denied';
                }
                $friendship->save();

            }
            // accepted is a temp name may change

            // What is Action_username?
            // Order may matter?
        }
        //if (isset( $req-> #####)) // have to figure out naming from json in req
            //$search_param = trim($req->#####)
            $search_users = User::where('username', '!=', Auth::user()->username)
              // may have to exclude friends/ rejected users?
                ->get();
    }
/*
    public function search(Request $req) {
        if (isset($req->search)) {
            $searchparam = trim($req->search);
            $search_users = User::where('username', '!=', Auth::user()->username)
                ->where(function($query) use ($searchparam) {
                    $query->where('username', 'like', '%' . $searchparam . '%')
                        ->orWhere('firstname', 'like', '%' . $searchparam . '%')
                        ->orWhere('lastname', 'like', '%' . $searchparam . '%')
                        ->orWhere('email', 'like', '%' . $searchparam . '%');
                })
                ->get();
            return view('search-friends', compact('search_users'));
        }
        return view('search-friends');
    }
*/
    /*
    public function search(Request $req) {
        if (isset($req->search)) {
            $searchparam = trim($req->search);
            $search_users = User::where('username', '!=', Auth::user()->username)
                ->where(function($query) use ($searchparam) {
                    $query->where('username', 'like', '%' . $searchparam . '%')
                        ->orWhere('firstname', 'like', '%' . $searchparam . '%')
                        ->orWhere('lastname', 'like', '%' . $searchparam . '%')
                        ->orWhere('email', 'like', '%' . $searchparam . '%');
                })
                ->get();
            return view('search-friends', compact('search_users'));
        }
        return view('search-friends');
    }
    */
}
