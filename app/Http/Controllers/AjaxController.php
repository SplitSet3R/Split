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
            $friendship = Friend::where('username2', '=', Auth::user()->username)
                ->where('username1', '=',  $req->username)
                ->where('status_code', '=', 'pending')
                ->where('action_username', '!=', Auth::user()->username)
                ->first();

            if (isset ($req->accepted)) {
                if ($req->accepted == 'accepted') {
                    $friendship->status_code = 'accepted';
                    $friendship->save();
                    return response()->json(array("message" => "friend request accepted!"), 200);
                } else if ($req->accepted == 'declined') {
                    $friendship->status_code = 'declined';
                    $friendship->save();
                    return response()->json(array("message" => "friend request denied!"), 200);
                }
            }
            // accepted is a temp name; may change
        }
        return response()->json(array("message" => "generic error message"), 500);
    }
}
