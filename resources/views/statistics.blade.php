@extends('layouts.app')
@section('content')
    <div class="main-panel">
        <div class="container-fluid">
            <h4>{{ Auth::user()->firstname}}'s expenses</h4>
            <h2> Statistics</h2>

        </div>
    </div>
@endsection
