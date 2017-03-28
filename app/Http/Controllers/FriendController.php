<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function Index(){
        $user = \App\User::find(Auth::user() -> username);
        $acceptedFriends = $user->acceptedFriends();
        $incomingRequests = $user->friendsRequests();
        return view('friends', compact('acceptedFriends', 'incomingRequests'));
    }
}
