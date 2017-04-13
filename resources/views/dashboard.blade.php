@extends('layouts.app')
@section('content')


    <div class="main-panel">

        <div class="col-sm-10">
            <div class='container'>
                <div class = "col-sm-7" id = "center-block">
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
                        <th><i class='fa fa-sort' aria-hidden='true'></i></th>
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
                              <td>
                                  @foreach ($allSharedExpenses as $sharedExpense)
                                      @if($sharedExpense->expense_id == $expense->id && Auth::user()->username == $sharedExpense->owner_username)
                                          {{ Form::open(['url' => 'settleSharedExpense', 'id' => 'settleSharedExpenseForm']) }}
                                          {{ Form::hidden('id', $sharedExpense->shared_expense_id, ['id'=>'id']) }}
                                          {{ Form::submit('Settle',['class'=> 'btn btn-info']) }}
                                          {{ Form::close() }}
                                      @endif
                                  @endforeach
                              </td>
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
                    <h4 style="font-family:arial;"><span style="color:goldenrod;font-weight:bold">Paid</span> Expenses</h4>
                        </div>
                      <br><br><br>
                    </div>
                <table class='table table-bordered'  id='displayTable'>
                    <thead class='thead-default'>
                    <tr class="bg-warning">
                      <th>Type<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Date<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Balance<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($allSettledExpenses))
                        @foreach ($allSettledExpenses as $settledExpense)
                            <tr>
                                <td>{{$settledExpense->id}}</td>
                                <td>{{$settledExpense->date_added}}</td>
                                <td>{{$settledExpense->date_settled}}</td>
                                <td style="">{{$settledExpense->amount_owed}}</td>
                                <td>{{$settledExpense->comments}}</td>
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

@endsection
