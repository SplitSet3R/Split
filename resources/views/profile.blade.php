@extends('layouts.app')
@section('content')
    <div class="wrapper">
        <div class="sidebar" data-color="green" >
            @include('includes.sidebar')
        </div>

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
                        <?php
                            // TODO upload user profile image - feature not yet implemented;
                            $avatar = Auth::user()->avatar;
                            if (isset($avatar)) {
                                echo "'<img src='" . asset('images/'. $avatar) . "'";
                                echo "id='profileImage'>";
                            } else {
                                // default profile pic
                                echo "'<img src='" . asset('images/default-profile-picture.jpg') . "'";
                                echo "id='profileImage'>";
                            }
                        ?>
                        <h2>{{ Auth::user()->username }}</h2>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped table-bordered table-hover text-center control-label">
                            <tr class="active">
                                <td>First Name: </td>
                                <td>{{ Auth::user()->firstname }}</td>
                            </tr>
                            <tr class="active">
                                <td>Last Name: </td>
                                <td>{{ Auth::user()->lastname }}</td>
                            </tr>
                            <tr class="active">
                                <td>Email: </td>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr class="active">
                                <td>Biography: </td>
                                <td>{{ Auth::user()->bio }}</td>
                            </tr>
                        </table>
                        <button class="btn btn-success openEditProfileModal" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                        @if(session('error'))
                            <br><br>
                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                        @endif
                        @if(session('success'))
                            <br><br>
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
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
                                <input type="text" name="firstname" id="modal_firstname" class="form-control" value="{{ Auth::user()->firstname }}">

                                {!! Form::label('lastname', 'Last name:') !!}
                                <input type="text" name="lastname" id="modal_lastname" class="form-control" value="{{ Auth::user()->lastname }}">

                                {!! Form::label('email', 'Email:') !!}
                                <input type="email" name="email" id="modal_email" class="form-control" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-md-6 text-center">
                                <br>
                                <img src="{{ asset('images/default-profile-picture.jpg') }}" id="profileImage">
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
