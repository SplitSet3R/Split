@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-3">
              <h4>{{ Auth::user()->name}}'s expenses</h4>
              <div>
                <table class='table'><thead><tr><th>OWED</th><th>OWES</th><th>TTL</th><th>BAL</th></tr></thead><tbody><tr><td class='text-success'><strong>+0</strong></td><td class='text-danger'><strong>-0</strong></td><td>0</td><td>0</td></tr></tbody>
                </table></div>
                <button href="#newExpense" class="btn btn-default" data-toggle="collapse">New Expense</button>
              <div class="collapse" id="newExpense">
                  <form id="expForm" action="{{Auth::user()->name}}/add" method="POST" class="form-horizontal">

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
                  <thead class='thead-default'><th>Type<i class='fa fa-sort' aria-hidden='true'></i></th><th>Date<i class='fa fa-sort' aria-hidden='true'></i></th><th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th><th>Owed<i class='fa fa-sort' aria-hidden='true'></i></th><th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th><th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
                  </thead><tbody></tbody></table>
              </div>
              <script>$('table').tablesort();</script>
        </div>
    </div>
</div>
@endsection
