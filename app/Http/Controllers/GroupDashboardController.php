<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupDashboardController extends Controller
{
    public function index() {
        return view('groups');
    }
}
