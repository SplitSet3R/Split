<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;

use Illuminate\Http\Request;

class GroupCreateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if (isset($req->name) &&  Group::where('name', '=', '$req->name')->get()->isEmpty()) {
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
                $groupMember->status_code = 'pending'; // have to change 'pending' into a constant
                $groupMember->action_group_id = #####; // have to figure out what this is
                $groupMember->is_Admin = 0;
                $groupMember->save();
            }
            return; // need to return somthing
        }
        return; // need to return somthing
    }
}
