<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;
use App\CustomClasses\Groups\GroupsStatusCodeEnum;

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
            'name' => 'required|unique:groups|max:255'
        ]);
        $group = new Group; // probably auto creates id
        $group->name = $req->name;
        $group->description = $req->description;
        $group->save();
        $adminGroupMember = new GroupMember;
        $adminGroupMember->group_id = $group->id;
        $adminGroupMember->username = Auth::user()->username;
        $adminGroupMember->status_code = GroupsStatusCodeEnum::ACCEPTED; // have to change 'accepted' into a constant
        $adminGroupMember->action_group_id = $group->id;
        $adminGroupMember->is_Admin = 1;
        $adminGroupMember->save();
        for ($i = 0; $i < sizeof($req->groupMembers); $i++) {
            $groupMember = new GroupMember;
            $groupMember->group_id = $group->id;
            $groupMember->username = $req->groupMembers[$i]->username;
            $groupMember->status_code = GroupsStatusCodeEnum::PENDING; // have to change 'pending' into a constant
            $groupMember->action_group_id = $group->id;
            $groupMember->is_Admin = 0;
            $groupMember->save();
        }
        return; // need to return somthing
    }

    /**
     * For filling select field in create group modal
     */
    public function index() {
        $friends = Auth::user()->acceptedFriends(); // Hansol  says she'll query on the front end
        return view('groups',compact('friends'));
    }
}