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
     * and the profile_name specified in the url
     */
    public function friendCheck($profile_name) {
        $entry = Friend::whereIn('username1', [Auth::user()->username, $profile_name])
            ->whereIn('username2', [Auth::user()->username, $profile_name])->get();
        if ($entry == null) {
            $entry = "hello";
        }
        return $entry;
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

        return view('debug', compact('status'));
    }
}
