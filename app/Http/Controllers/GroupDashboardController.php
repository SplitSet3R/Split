<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /*
     *  if (isset($req->search)) {
            $searchparam = trim($req->search);

            // Search users that match the search keyword
            $search_users = User::where('username', '!=', Auth::user()->username)
                    ->where(function($query) use ($searchparam) {
                        $query->where('username',    'like', '%' . $searchparam . '%')
                              ->orWhere('firstname', 'like', '%' . $searchparam . '%')
                              ->orWhere('lastname',  'like', '%' . $searchparam . '%')
                              ->orWhere('email',     'like', '%' . $searchparam . '%');
                    })->get();

            // Get users that are already related toe user in any way (Pending, Accepted, Rejected)
            $related_users = Auth::user()->allRelatedUsers();

            return view('search-friends', compact('search_users', 'related_users'));
        }
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
