@extends('layouts.app')
@section('content')
    <div class="container main-panel">
        <h4>Groups Expanse Dashboard</h4>
        <hr>

        <div class = 'col-sm-8'>
            <h5>Create Group</h5>
            <button class="btn btn-primary openCreateGroupModal" data-toggle="modal" data-target="#createGroupModal">
                 Create</button>

            <hr>

            <h5>My Groups: </h5>
            <table id="myTalbe" class="table table-striped table-bordered table-hover table-condensed text-center">
                <thead class="thead-default">
                <tr class = "success">
                    <th class="text-center">Id</th>
                    <th class="text-center">Group Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">I owed</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>

                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{$group->id}}</td>
                        <td>{{$group->name}}</td>
                        <td>{{$group->description}}</td>
                        <td></td>
                        <td><button class="btn btn-info open-EditGroupDialog"
                                    data-toggle="modal"
                                    data-target="#EditGroupModal"
                                    >Edit</button></td>
                        <td><button class="btn btn-danger open-DeleteGroupDialog"
                                    data-toggle="modal"
                                    data-target="#deleteGroupModal"
                                    >Delete</button></td>
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
                    <div class="modal-body">
                        {{ Form::open(['url' => 'creategroup']) }}
                        <h4>Create Groups</h4>
                        <div class="">
                            {!! Form::label('name', 'Group Name:', ['class'=>'control-label']) !!}
                            {!! Form::text('name', '', array('id'=>'name',
                                    'class'=>'form-control')) !!}
                        </div>
                        <div class="">
                            {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!}
                            {!! Form::text('description', '', array('id'=>'description',
                                    'class'=>'form-control')) !!}
                        </div>
                        <div class="">
                            <br>
                            <p><strong>Select Your Group member</strong></p>
                            @foreach($allfriends as $allfriend)
                                <input id="groupMembers" type="checkbox" name="groupMembers[]" value="{{$allfriend->username}}">
                                <label for="groupMembers">{{$allfriend->username}}</label><br>
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
            </div>
        </div>
    </div>
    <div class="modal fade openEditGroupModal" id="EditGroupModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="EditGroupModalLabel"></h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => 'updategroup']) }}
                    <h4>Create Groups</h4>
                    <div class="">
                        {!! Form::label('name', 'Group Name:', ['class'=>'control-label']) !!}
                        {!! Form::text('name', '', array('id'=>'name',
                                'class'=>'form-control')) !!}
                    </div>
                    <div class="">
                        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!}
                        {!! Form::text('description', '', array('id'=>'description',
                                'class'=>'form-control')) !!}
                    </div>
                    <div class="">
                        <br>
                        <p><strong>Select Your Group member</strong></p>
                        @foreach($allfriends as $allfriend)
                            <input id="groupMembers" type="checkbox" name="groupMembers[]" value="{{$allfriend->username}}">
                            <label for="groupMembers">{{$allfriend->username}}</label><br>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <span class="pull-right">
                                            {!! Form::submit('Edit',['class'=> 'btn btn-info form-control']) !!}
                        </span>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteGroupModal" tabindex="-1" role="dialog" aria-labeleledby="deleteGroupModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteGroupeModalLabel">Delete Group</h4>
                </div>

                {!! Form::open(['url' => '/groupDelete', 'id' => 'deleteGroupForm']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <table class="table table-bordered table-condensed">
                            {!! Form::hidden('modal_group_delete', '', ['id'=>'modal_group_delete']) !!}
                            {!! Form::submit('Confirm',['class'=> 'btn btn-info',
                                             'id' => 'deleteGroupBtn']) !!}
                        </table>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeDeleteGroupBtn" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.open-DeleteGroupDialog', function() {
            document.getElementById('deleteGroupForm').reset();
            var group_id = $(this).parent().siblings(":first").text();
            console.log(group_id);

            $('.modal-body #modal_groupid_delete').attr('value', group_id);
        });
    </script>

@endsection
