<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /*
     * Returns query results based on the search request.
     * Exludes the user who is currently authenticated from
     * search results.
     */
    public function search(Request $req) {
        if (isset($req->search)) {
            $query = trim($req->search);
            $search_users = User::where('username', 'like', '%' . $query . '%')
                ->where('username', '!=', Auth::user()->username)
                ->get();
            return view('search-friends', compact('search_users'));
        }
        return view('search-friends');
    }

    /*
     * Returns the default view of the search page.
     */
    public function index() {
        return view('search-friends');
    }
}
