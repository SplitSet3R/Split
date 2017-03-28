<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function Index(){
        $user = \App\User::find(Auth::user() -> username);
        return view('groups')->with('data', $user->groups);
    }
    public function Create(array $data){
        return Group::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }
}
