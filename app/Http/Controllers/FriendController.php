<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user = \App\User::find(Auth::user() -> username);
        $acceptedFriends = $user->acceptedFriends();
        $incomingRequests = $user->friendsRequests();
        //TODO return view file once Front End completes it
        return view('friends', compact('acceptedFriends', 'incomingRequests'));
    }
}
