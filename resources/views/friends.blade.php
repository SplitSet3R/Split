@extends('layouts.app')
@section('content')
    <div class="container main-panel">
        <h3>Friends</h3>
        <br />
        <h3>Pending Friend Requests</h3>

            @if(isset($incomingRequests) && count($incomingRequests) > 0)

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="well">
                @foreach($incomingRequests as $user)
                    <!-- TODO route to user's profile-->
                        <a href="#"> {{ $user->firstname . " " . $user->lastname }}</a> ( {{$user->username}} )
                    <span class="pull-right" id="declined-{{ $user->username }}"><button type="button" onclick="friendRequestResponse('{{ $user->username }}', this.value)" class="btn btn-danger" name="accepted" value="declined">Decline</button></span>
                    <span class="pull-right" id="accept-{{ $user->username }}"><button type="button" onclick="friendRequestResponse('{{$user->username}}', this.value)" class="btn btn-danger" name="accepted" value="accepted">Accept</button></span>
                    <span class="pull-right" id="feedback"></span>
                    <hr/>
                    @endforeach
                </div>
            @elseif (isset($incomingRequests) && count($incomingRequests) == 0)
            {{var_dump($incomingRequests)}}
                <h3>No friend requests to show</h3>
            @endif

        <br />
        <div class="container">
            <h3>Friends List</h3>
        @if(isset($acceptedFriends) && count($acceptedFriends) > 0)
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="well">
                @foreach($acceptedFriends as $user)
                    <!-- TODO route to user's profile-->
                        <a href="#"> {{ $user->firstname . " " . $user->lastname }}</a> ( {{$user->username}} )
                        <hr />
                    @endforeach
                </div>
            @elseif (isset($acceptedFriends) && count($acceptedFriends) == 0)
                <h3>You have no friends to show :(</h3>
            @endif
        </div>
    </div>
@endsection
