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
                            $uploadedImg = false;
                            if ($uploadedImg) {
                                echo "'<img src='" . asset('images/#uploaded_user_profile') . "'";
                                echo "id='profileImage'" . "style='width: 200px;'>";
                            } else {
                                // default profile pic
                                echo "'<img src='" . asset('images/default-profile-picture.jpg') . "'";
                                echo "id='profileImage'" . "style='width: 200px;'>";
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
                                <td>Active expenses: </td>
                                <td></td>
                            </tr>
                            <tr class="active">
                                <td>Total expenses: </td>
                                <td></td>
                            </tr>
                            <tr class="active">
                                <td>Total friends: </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div> <!-- row -->
            </div> <!-- container-fluid -->
        </div> <!-- main-panel -->
    </div> <!-- wrapper -->
@endsection
