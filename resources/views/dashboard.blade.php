@extends('layouts.app')
@section('content')
    <div class="main-panel">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <h4>{{ Auth::user()->firstname}}'s expenses</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger openAddExpenseModal" data-toggle="modal" data-target="#addExpenseModal">Add Expense</button>
                </div>
            </div>
          <div>
              <table class='table'><thead><tr><th>OWED</th><th>OWES</th><th>TTL</th><th>BAL</th></tr></thead><tbody><tr><td class='text-success'><strong>+0</strong></td><td class='text-danger'><strong>-0</strong></td><td>0</td><td>0</td></tr></tbody>
              </table>
          </div>
        </div>
        <div class="col-sm-9">
              <!--
              <form method="get" action="">
              <label>Order By</label>
              <select name="orderby">
                  <option value="most_recent">Most Recent</option>
                  <option value="amount">Highest Total Amount</option>
                  <option value="amount_owed">Highest Amount Owed</option>
                  <option value="type">Type</option>
              </select>
              <h3>You have no friends!</h3>

                      <br>
              <input type="submit" name="sortBtn">
              </form>-->
              <div class='container'>
                <table class='table' style='width:75%;' id='displayTable'>
                    <thead class='thead-default'>
                      <th>Type<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Date<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Owed<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
                    </thead>
                    <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{$expense->type}}</td>
                            <td>{{$expense->date_added}}</td>
                            <td>{{$expense->amount}}</td>
                            <td>{{$expense->amount_owed}}</td>
                            <td>{{$expense->secondary_username}}</td>
                            <td>{{$expense->comments}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
              <!--<script>$('table').tablesort();</script>-->
        </div>
    </div>

    <div class="modal fade openAddExpenseModal" id="addExpenseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addExpenseModalLabel">Add an Expense</h4>
                </div>

                <form id="expForm" action="/{{ Auth::user()->username }}/addexpense" method="POST" class="form-horizontal">
                    <div class="modal-body">
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
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="number" value="0.00" id="expAmountInput" class="form-control required"
                                   min="0" max="9999.99" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" name="expAmount">
                        </div>
                        <label class="control-label">Comments</label>
                        <input type="textarea" name="expComments" class="form-control">
                        <br>
                        <button href="#newExpenseOwed" data-toggle="collapse" class="btn btn-default">Owed</button>
                        <div class="collapse" id="newExpenseOwed">
                            <h3>You have no friends!</h3>
                            <label class="control-label">Owed</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" value="0.00" id="expOwedInput" class="form-control required"
                                       min="0" max="9999.99" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" name="expOwedAmount">
                            </div>
                            <label class="control-label">Comments:</label>
                            <input type="textarea" class="form-control" name="expOwerComments">
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
