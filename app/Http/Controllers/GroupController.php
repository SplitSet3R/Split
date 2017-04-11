<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user = \App\User::find(Auth::user() -> username);

    }
    public function create(array $data){
        return Group::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }
}
