<?php

namespace App\Http\Controllers;

// use App\GroupMember;
use Illuminate\Support\Facades\DB;
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
        // $groups = GroupMember::where('username', '=', Auth::user()->username)->get();
        $owedToGroup = DB::table('groupmembers')
            ->join('groups', 'groupmembers.group_id', 'groups.id')
            ->join('groupsharedexpenses', 'groupmembers.username', 'groupsharedexpenses.username')
            ->select('groups.name', 'groupsharedexpenses.amount_owed')
            ->get();
        return view('groups',compact('owedToGroup'));
    }
}
