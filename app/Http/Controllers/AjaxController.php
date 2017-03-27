<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                return response()->json(array("message" => "friend added successfully"), 200);
            }
        }
        return response()->json(array("message" => "generic error message"), 500);
    }
}
