<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;

use Illuminate\Http\Request;

class GroupCreateController extends Controller
{
    //get friend list

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $this->validate($req, [
            'name' => 'required|unique:posts|max:255' //don't know what posts do and the max value is temporary
        ]);
        if (isset($req->name) &&  Group::where('name', '=', $req->name)->get()->isEmpty()) {
            $group = new Group; // probably auto creates id
            $group->name = $req->name;
            $group->description = $req->description;
            $group->save();
            $adminGroupMember = new GroupMember;
            $adminGroupMember->group_id = $group->id;
            $adminGroupMember->username = Auth::user()->username; // couldn't test Auth::user()->username; Auth::user returns null
            $adminGroupMember->status_code = 'accepted'; // have to change 'accepted' into a constant
            // removed $adminGroupMember->action_group_id
            $adminGroupMember->is_Admin = 1;
            $adminGroupMember->save();
            for ($i = 0; $i < sizeof($req->groupMembers); $i++) {
                $groupMember = new GroupMember;
                $groupMember->group_id = $group->id;
                $groupMember->username = $req->groupMembers[$i]->username;
                $groupMember->status_code = 'pending'; // have to change 'pending' into a constant
                // removed $groupMember->action_group_id
                $groupMember->is_Admin = 0;
                $groupMember->save();
            }
            return; // need to return somthing
        }
        return; // need to return somthing
    }

    /**
     * For filling select field in create group modal
     */
    public function index() {
        // $friends = Friend::where('username1', '=', Auth::user()->username)->get();
        // $friends2 = Friend::where('username2', '=', Auth::user()->username)->get();
        $friends = Friend::all(); // Hansol  says she'll query on the front end
        return view('groups',compact('friends'));
    }
}
