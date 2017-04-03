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
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class ="">
                            <label class="control-label">Group Name</label>
                            <input type="text"  name="groupName" id="groupNmae" class ="form-control">
                        </div>

                        <div class ="">
                            <label class="control-label">Discription</label>
                            <input type="text"  name="groupDisc" id="groupDisc" class ="form-control">
                        </div>



                    </div>

                    <div class="modal-footer">
                        <input type="submit" placeholder="Submit" id="expSubmit" name="newExpBtn" class="btn btn-success openAddExpenseModal">
                        <button type="button" id="closeAddExpenseBtn" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
