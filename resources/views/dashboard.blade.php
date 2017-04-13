@extends('layouts.app')
@section('content')


    <div class="main-panel">
        <div class="col-sm-8">
            <div class='container'>
                <div class = "col-sm-7">
                    <h2><span style="color:darkgreen;font-weight:bold">{{ Auth::user()->firstname}}'s expenses</span></h2>
                    <hr>

                    <h4 style="font-family:arial;"><span style="color:goldenrod;font-weight:bold">Summary</span> of Expenses</h4>
              <table class="table table-bordered "  id="displayTable">
                <thead>
                  <tr class="bg-warning">
                      <th >OWED</th>
                      <th >OWES</th>
                      <th >TTL</th>
                      <th >BAL</th>
                  </tr>
                </thead>
                  <tbody><tr><td class='text-success'><strong>+0</strong></td><td class='text-danger'><strong>-0</strong></td><td>0</td><td>0</td></tr></tbody>
              </table>
                <hr>

                    <h4 style="font-family:arial;"><span style="color:goldenrod;font-weight:bold">Outstanding</span> Expenses</h4>
                <table class='table table-bordered' id='displayTable'>
                    <thead class='thead-default'>
                    <tr class="bg-warning">
                      <th class="col-xs-1">Type<i class='fa fa-sort' aria-hidden='true'></i></>
                      <th>Date<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Balance<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($expenses as $expense)
                      @if(Auth::user()->username == $expense->owner_username && $expense->secondary_username!=null)
                      <?php $balanceStyle = array(['class'=>'text-success', 'operator' => '+']); ?>
                      @elseif(Auth::user()->username == $expense->secondary_username)
                      <?php $balanceStyle = array(['class'=>'text-danger', 'operator' => '-']); ?>
                      @else
                      <?php $balanceStyle = array(['class'=>'', 'operator' => '']); ?>
                      @endif
                          <tr>
                              <td>{{$expense->type}}</td>
                              <td>{{$expense->date_added}}</td>
                              <td>{{$expense->amount}}</td>
                              <td class="{{$balanceStyle[0]['class']}}">{{$balanceStyle[0]["operator"]}} {{$expense->amount_owed}}</td>
                              @if($expense->owner_username==Auth::user()->username && $expense->secondary_username != null)
                                <td><a href="profile/{{$expense->secondary_username}}">{{$expense->secondary_username}}</a></td>
                              @elseif($expense->owner_username!=Auth::user()->username)
                                <td><a href="profile/{{$expense->owner_username}}">{{$expense->owner_username}}</a></td>
                              @else
                                <td></td>
                              @endif
                              <td>{{$expense->comments}}</td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
                    <hr>


              <!--<script>$('table').tablesort();</script>-->

                    <div class="row">
                        <div class="col-sm-4">
                    <h4 style="font-family:arial;"><span style="color:goldenrod;font-weight:bold">Settled</span> Expenses</h4>
                        </div>
                        <div class="col-sm-3">
                    <button class="btn btn-info open-SettledExenseDialog"
                            data-toggle="modal"
                            data-target="#settledExenseModal"
                    >Share</button></div><br><br><br>
                    </div>
                <table class='table table-bordered'  id='displayTable'>
                    <thead class='thead-default'>
                    <tr class="bg-warning">
                      <th>Type<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Date<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Balance<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($settledExpenses))
                    @foreach ($settledExpenses as $expense)
                        <tr>
                            <td>{{$expense->type}}</td>
                            <td>{{$expense->date_added}}</td>
                            <td>{{$expense->amount}}</td>
                            <td style="">{{$expense->amount_owed}}</td>
                            <td><a href="profile/{{$expense->secondary_username}}">{{$expense->secondary_username}}</a></td>
                            <td>{{$expense->comments}}</td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
              </div>
              <!--<script>$('table').tablesort();</script>-->
        </div>
    </div>


    <div class="modal fade settledExenseModal" id="settledExenseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="settledExenseModalLabel">Share Expanse</h4>
                </div>

                <form id="expForm" action="" method="POST" class="form-horizontal" autocomplete="on">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="control-label">Type</label>
                        <select name="expType" class="form-control" >
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
                        @if ($errors->has('expType'))
                            <span class="help-block">
                            <strong>{{ $errors->first('expType') }}</strong>
                        </span>
                        @endif

                        <label class="control-label">Date</label>
                        <input type="date" name="expDate" value="{{\Carbon\Carbon::now()->toDateString()}}" class="form-control required">

                        @if ($errors->has('expDate'))
                            <span class="help-block">
                            <strong>{{ $errors->first('expDate') }}</strong>
                        </span>
                        @endif

                        <div class="">
                            <br>
                            <!--TODO dropdown or serch bar for frends.-->
                            <p><strong>choose your frined</strong></p>
                            @foreach($allfriends as $allfriend)
                                <input id="groupMembers" type="checkbox" name="groupMembers[]" value="{{$allfriend->username}}">
                                <label for="groupMembers">{{$allfriend->username}}</label><br>
                            @endforeach
                        </div>
                        <label class="control-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="number" placeholder="0.00" id="expAmountInput" class="form-control required"
                                   min="0" max="9999.99" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" name="expAmount">
                        </div>

                        @if ($errors->has('expAmount'))
                            <span class="help-block">
                            <strong>{{ $errors->first('expAmount') }}</strong>
                        </span>
                        @endif
                        <label class="control-label">Comments</label>
                        <input type="textarea" name="expComments" class="form-control">
                        <br>
                        <button id="owedButton" href="#newExpenseOwed" data-toggle="collapse" class="btn btn-default">Owed</button>
                        <div class="collapse" id="newExpenseOwed">
                            <label class="control-label">Friends</label>
                            <input id="expOwerUsername" onload="retrieveFriends" type="text" class="form-control" name="username" autocomplete="on">
                            <div id="friend-pill" style="display:none;">
                                <a class="btn btn-danger" href="#">
                                    <span class="friend-text"></span>
                                    <div style="display:inline"onclick="deleteFriendFromAddExpense()"><i class="glyphicon glyphicon-remove"></i></div>
                                </a>
                            </div>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                            <label class="control-label">Owed</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" value="" placeholder="0.00" id="expOwedInput" class="form-control required"
                                       min="0" max="9999.99" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" name="expOwedAmount">
                            </div>
                            @if ($errors->has('expOwedAmount'))
                                <span class="help-block">
                                <strong>{{ $errors->first('expOwedAmount') }}</strong>
                            </span>
                            @endif
                            <label class="control-label">Comments:</label>
                            <input type="textarea" class="form-control" name="expOwerComments">

                            <!-- TODO comments should be nullable. Back end issue -->
                            @if ($errors->has('expOwerComments'))
                                <span class="help-block">
                                <strong>{{ $errors->first('expOwerComments') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" placeholder="Submit" id="expSubmit" name="newExpBtn" class="btn btn-success settledExenseModal">
                        <button type="button" id="closeAddExpenseBtn" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
