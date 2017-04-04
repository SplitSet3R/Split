@extends('layouts.app')
@section('content')
    <div class="container main-panel">
        <h4>Groups Expanse Dashboard</h4>
        <hr>

        <div class = 'col-sm-8'>
            <h5>Create Group</h5>
            <button class="btn btn-danger openCreateGroupModal" data-toggle="modal" data-target="#createGroupModal">
                 Create</button>

            <hr>

            <h5>My Groups: </h5>
            <table id="myTalbe" class="table table-striped table-bordered table-hover table-condensed text-center">
                <thead class="thead-default">
                <tr class = "success">
                    <th class="text-center">Group id</th>
                    <th class="text-center">Group Name</th>
                    <th class="text-center">I owed</th>
                    <th class="text-center">Owed To me</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>

                </tr>
                </thead>

                <tbody>
                @foreach ($friends as $friend)
                    <tr>
                        <td>{{$friend->id}}</td>
                        <td>{{$friend->username2}}</td>

                    </tr>
                @endforeach
                </tbody>

            </table>


        </div>

    </div>
    <div class="modal fade openCreateGroupModal" id="createGroupModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="CreateGroupModalLabel"></h4>
                </div>

                <form id="expForm" action="/{{ Auth::user()->username }}/groups" method="POST" class="form-horizontal">
                    <div class="modal-body">
                        {{ Form::open(['url' => 'creategroup']) }}
                        <h4>Create Groups</h4>
                        <div class="">

                            {!! Form::label('modal_group_name', 'Group Name:', ['class'=>'control-label']) !!}
                            {!! Form::text('modal_group_name', '', array('id'=>'name',
                                    'class'=>'form-control')) !!}
                        </div>
                        <div class="">
                            {!! Form::label('modal_desc', 'Description:', ['class'=>'control-label']) !!}
                            {!! Form::text('modal_desc', '', array('id'=>'description',
                                    'class'=>'form-control')) !!}
                        </div>
                        <div class="">
                            {!! Form::label('modal_desc', 'Select Friends:', ['class'=>'control-label']) !!}<br>
                            @foreach($friends as $friend)
                                <input id="friend" type="checkbox" name="friend[]" value="friend" />
                                <label for="username2">{{$friend->username2}}</label><br>
                            @endforeach

                         </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <span class="pull-right">
                                            {!! Form::submit('Create',['class'=> 'btn btn-info form-control']) !!}
                        </span>
                    </div>
                    {{ Form::close() }}





                </form>
            </div>
        </div>
    </div>

@endsection
