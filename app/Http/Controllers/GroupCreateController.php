<?php

namespace App\Http\Controllers;

use App\Friend;
use Auth;
use App\Group;
use App\GroupMember;
use App\CustomClasses\Groups\GroupsStatusCodeEnum;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $groupMember->username = $req->groupMembers[$i];
            $groupMember->status_code = GroupsStatusCodeEnum::PENDING; // have to change 'pending' into a constant
            $groupMember->action_group_id = $group->id;
            $groupMember->is_Admin = 0;
            $groupMember->save();
        }
        return redirect()->action('GroupCreateController@index');
    }

    public function deleteGroup(Request $req) {
        if (Group::find($req->modal_groupid_delete)) {
            $group = Group::find($req->modal_groupid_delete);
            $group->delete();
        }
        return redirect()->action('GroupCreateController@index');
    }

    public function updateGroup(Request $req) {
        if (Group::find($req->id)) {
            $group = Group::find($req->id);
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
                $groupMember->username = $req->groupMembers[$i];
                $groupMember->status_code = GroupsStatusCodeEnum::PENDING; // have to change 'pending' into a constant
                $groupMember->action_group_id = $group->id;
                $groupMember->is_Admin = 0;
                $groupMember->save();
            }

        }
        return redirect()->action('GroupCreateController@index');
    }

    /**
     * For filling select field in create group modal
     */
    public function index() {
        //$friends = Auth::user()->acceptedFriends(); // Hansol  says she'll query on the front end
        $friends = Friend::where('username1', '=', Auth::user()->username)
            ->select('username2 AS username')
            ->get();

        $friends2 = Friend::where('username2', '=', Auth::user()->username)
            ->select ('username1 AS username')
            ->get();
        $allfriends = $friends->union($friends2);

        /*
        $groups = DB('groupmembers')
            ->join('groups', 'groupmembers.group_id', 'groups.id')
            ->join('groupexpenses', 'groups.id', 'groupexpenses.group_id')
            ->select('groupmembers.username', 'groups.id', 'groups.name', 'groupexpenses.amount')
            ->get();

        */

        $groups = DB::table('groups AS g')
            ->join('groupmembers AS gm','g.id', '=', 'gm.group_id')
            ->get();
        //$groups =Group::All();

        // amount is for the group not for the individual
        return view('groups', compact('allfriends','groups'));
    }
}
