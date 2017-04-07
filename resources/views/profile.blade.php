@extends('layouts.app')
@section('content')
    <div class="wrapper">

        <div class="main-panel">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <h5>User Profile</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 text-center">
                        @php
                            // TODO upload user profile image - feature not yet implemented;
                            $avatar = $user->avatar;
                            if (isset($avatar)) {
                                echo "'<img src='" . asset('images/'. $avatar) . "' id='profileImage'>";
                            } else {
                                echo "'<img src='" . asset('images/default-profile-picture.jpg') . "' id='profileImage'>";
                            }
                        @endphp
                        <h2>{{ $user->username }}</h2>
                    </div>
                    <div class="col-md-6">
                        @if(session('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                        @endif
                        @if(session('success'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                        @endif
                        @if($permission==config('constants.FRIENDS') || $user->username==Auth::user()->username)
                        <table class="table table-striped table-bordered table-hover text-center control-label">
                            <tr class="active">
                                <td>First Name: </td>
                                <td>{{ $user->firstname }}</td>
                            </tr>
                            <tr class="active">
                                <td>Last Name: </td>
                                <td>{{ $user->lastname }}</td>
                            </tr>
                            <tr class="active">
                                <td>Email: </td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr class="active">
                                <td>Biography: </td>
                                <td>{{ $user->bio }}</td>
                            </tr>
                        </table>
                          @if($permission==config('constants.FRIENDS'))
                          <h3>You and {{$user->username}} are friends! Buy lots of things together!</h3>
                          @endif
                        @endif
                        @if($permission==config('constants.NOT_FRIENDS'))
                        <form method="POST" action="/search">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <span class="pull-right">
                            <button type="button" onclick="addFriend(this.value)" class="btn btn-danger" name="add-friend" value="{{$user->username}}">Add Friend</button>
                            <h1>You are not yet friends with {{$user->username}}</h1>
                          </span>
                        </form>
                        @endif
                        @if($permission==config('constants.PENDING'))
                        <span class="pull-right">
                          <button type="button" onclick="addFriend(this.value)" class="btn btn-danger" name="add-friend" value="{{$user->username}}">Your Friend Request is Pending</button>
                        </span>
                        @endif
                        @if($user->username==Auth::user()->username)
                        <button class="btn btn-success openEditProfileModal" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                        @endif
                    </div>
                </div> <!-- row -->
            </div> <!-- container-fluid -->
        </div> <!-- main-panel -->
    </div> <!-- wrapper -->

    <div class="modal fade openEditProfile" id="editProfileModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editProfileLabel">Edit Profile</h4>
                </div>
                <form id="editProfileForm" action="/profile/{{ Auth::user()->username }}/edit" method="POST" class="form-horizontal">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('username', 'Username:') !!}
                                <input type="text" name="username" id="modal_username" class="form-control" value="{{ Auth::user()->username }}" readonly="true">

                                {!! Form::label('firstname', 'First name:') !!}
                                <input type="text" name="firstname" id="modal_firstname" class="form-control" value="{{ Auth::user()->firstname }}" required="true">

                                {!! Form::label('lastname', 'Last name:') !!}
                                <input type="text" name="lastname" id="modal_lastname" class="form-control" value="{{ Auth::user()->lastname }}" required="true">

                                {!! Form::label('email', 'Email:') !!}
                                <input type="email" name="email" id="modal_email" class="form-control" value="{{ Auth::user()->email }}" required="true">
                            </div>
                            <div class="col-md-6 text-center">
                                <br>
                                @php
                                    $avatar = Auth::user()->avatar;
                                    if (isset($avatar)) {
                                        echo "'<img src='" . asset('images/'. $avatar) . "' id='profileImage'>";
                                    } else {
                                        echo "'<img src='" . asset('images/default-profile-picture.jpg') . "' id='profileImage'>";
                                    }
                                @endphp
                                <br><br>
                                {{-- TODO avatar table to pull selections, unless we hardcode their options below
                                <select name="avatar" id="modal_avatar" class="alert-info">
                                    @foreach($avatars as $avatar)
                                        <option value="{{ $avatar->src }}">{{ $avatar->avatar_name }}</option>
                                    #@endforeach
                                </select>
                                --}}
                                <select name="avatar" id="modal_avatar" class="alert-info">
                                    <option value="default-profile-picture.jpg">Default</option>
                                    <option value="avatar1">Avatar 1</option>
                                    <option value="avatar2">Avatar 2</option>
                                    <option value="avatar3">Avatar 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                {!! Form::label('bio', 'Biography:') !!}
                                <textarea name="bio" id="modal_bio" class="form-control" rows="3" cols="75" placeholder="Enter your biography here...">{{ Auth::user()->bio }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save',['class'=> 'btn btn-success', 'id' => 'editProfileBtn']) !!}
                        <button type="button" id="closeEditProfileBtn" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </form>
             </div>
         </div>
     </div>
 @endsection
