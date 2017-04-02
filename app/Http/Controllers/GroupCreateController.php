<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupCreateController extends Controller
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
*/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if ($req->json() && isset($req->name)) {
            $group = new Group; // probably auto creates id
            $group->name = $req->name;
            $group->description = $req->description;
            $group->save();
            // admin could be first entry in group members input table (ie. can be included in the for loop)
                // unmodifiable on front end
            $adminGroupMember = new GroupMember;
            $adminGroupMember->group_id = $group->id;
            $adminGroupMember->username = Auth::user()->username; // couldn't test Auth::user()->username; Auth::user returns null
            $adminGroupMember->status_code = 'accepted'; // have to change 'accepted' into a constant
            $adminGroupMember->action_group_id = #####; // have to figure out what this is
            $adminGroupMember->is_Admin = 1;
            $adminGroupMember->save();
            for ($i = 0; $i < sizeof($req->groupMembers); $i++) {
                $groupMember = new GroupMember;
                $groupMember->group_id = $group->id;
                $groupMember->username = $req->groupMembers[$i]->username;
                $groupMember->status_code = 'pending'; // have to change 'accepted' into a constant
                $groupMember->action_group_id = #####; // have to figure out what this is
                $groupMember->is_Admin = 0;
                $groupMember->save();

            }
        }
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
