<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableListController extends Controller
{
    public function index() {
        return view('tableList');
    }
}
