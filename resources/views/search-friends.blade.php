@extends('layouts.app')
@section('content')
<div class="container main-panel">
  <h3>Search Users</h3>
  <hr />
  <form method="POST" action="/search">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-6">
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button name="submit" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></button>
                </span>
              </div>
        </div>
    </div>
  <br />
  @if(isset($search_users) && count($search_users) > 0)
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="well">
        @foreach($search_users as $user)
        <!-- TODO route to user's profile-->
        <a href="#"> {{ $user->firstname . " " . $user->lastname }}</a> ( {{$user->username}} )
          <span class="pull-right"><button type="button" onclick="addFriend(this.value)" class="btn btn-danger" name="add-friend" value="{{$user->username}}">Add</button></span>
        <hr />
        @endforeach
    </div>
    @elseif (isset($search_users) && count($search_users) == 0)
      <h3>No users to show</h3>
    @endif
  </form>
</div>
@endsection
