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
                        <img src="http://split.app/images/default-profile-picture.jpg" id="profileImage" style="width: 200px;">
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

                        <button href="#newExpense" class="btn btn-danger" data-toggle="collapse">Add expense for {{ Auth::user()->username }}</button>
                        <div class="collapse" id="newExpense">
                            <form id="expForm" action="/{{ Auth::user()->username }}/addexpense" method="POST" class="form-horizontal">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label class="control-label">Type</label>
                                <select name="expType" class="form-control">
                                    <option value="Utilities">Utilities</option>
                                    <option value="Groceries">Groceries</option>
                                    <option value="Household">Household</option>
                                    <option value="Rent">Rent/Mortgage</option>
                                    <option value="Loan">Loan</option>
                                    <option value="Restaurants">Restaurants</option>
                                    <option value="Active">Active</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Hobbies">Hobbies</option>
                                    <option value="Work">Work</option>
                                    <option value="Insurance">Insurance</option>
                                    <option value="Savings">Savings</option>
                                </select>
                                <label class="control-label">Date</label>
                                <input type="date" name="expDate" class="form-control required">
                                <label class="control-label">Amount</label>
                                <input type="text" name="expAmount" class="form-control required">
                                <label class="control-label">Comments</label>
                                <input type="textarea" name="expComments" class="form-control">
                                <button href="#newExpenseOwed" data-toggle="collapse" class="btn">Owed</button>
                                <div class="collapse" id="newExpenseOwed">
                                    <h3>You have no friends!</h3>

                                    <label class="control-label">Owed</label>
                                    <input type="text" placeholder="Amount owed" class="form-control" name="expOwedAmount">
                                    <label class="control-label">Comments:</label>
                                    <input type="textarea" class="form-control" name="expOwerComments">
                                </div>
                                <input type="submit" placeholder="Submit" id="expSubmit" name="newExpBtn" class="btn">
                            </form>
                            <script>
                                //$("#expForm").validate();
                            </script>
                        </div> <!-- collapse -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container-fluid -->
        </div> <!-- main-panel -->
    </div> <!-- wrapper -->
@endsection
