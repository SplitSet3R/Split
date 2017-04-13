@extends('layouts.app')
@section('content')


    <div class="main-panel">
        <div class="col-sm-7">
            <div class="container">
                @if(session('settled'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('settled') }}</p>
                @endif
                <h4>{{ Auth::user()->firstname}}'s expenses</h4>
                <div>
                    <h2>Summary of Expenses</h2>
                    <table class='table' id="displayTable">
                        <thead>
                        <th>OWED</th>
                        <th>OWES</th>
                        <th>TTL</th>
                        <th>BAL</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='text-success'><strong>{{$summary['owed']}}</strong></td>
                            <td class='text-danger'><strong>{{$summary['owing']}}</strong></td>
                            <td>{{$summary['ttl']}}</td>
                            <td>{{$summary['bal']}}</td>
                        </tr>
                        </tbody>
                    </table>
            </div>
          </div>
        </div>
        <div class="col-sm-7">
              <div class='container'>
                <h2>Outstanding Expenses</h2>
                <table class='table' id='displayTable'>
                    <thead class='thead-default'>
                      <th>Settle<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Type<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Date<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Balance<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
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
                                      @if($sharedExpense->expense_id == $expense->id)
                                          {{ Form::open(['url' => 'settleSharedExpense', 'id' => 'settleSharedExpenseForm']) }}
                                          {{ Form::hidden('id', $sharedExpense->id, ['id'=>'id']) }}
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
              </div>
              <!--<script>$('table').tablesort();</script>-->
        </div>
        <div class="col-sm-7">
              <div class='container'>
                <h2>Settled Expenses</h2>
                <table class='table'  id='displayTable'>
                    <thead class='thead-default'>
                        <th><i class='fa fa-sort' aria-hidden='true'></i></th>
                        <th>Date Added<i class='fa fa-sort' aria-hidden='true'></i></th>
                        <th>Date Settled<i class='fa fa-sort' aria-hidden='true'></i></th>
                        <th>Amount Owed<i class='fa fa-sort' aria-hidden='true'></i></th>
                        <th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th>
                        <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
                    </thead>
                    <tbody>
                    @if(isset($allSettledExpenses))
                        @foreach ($allSettledExpenses as $settledExpense)
                            <tr>
                                <td>{{$settledExpense->id}}</td>
                                <td>{{$settledExpense->date_added}}</td>
                                <td>{{$settledExpense->date_settled}}</td>
                                <td style="">{{$settledExpense->amount_owed}}</td>
                                <td><a href="profile/{{$settledExpense->secondary_username}}">{{$settledExpense->secondary_username}}</a></td>
                                <td>{{$settledExpense->comments}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
              </div>
              <!--<script>$('table').tablesort();</script>-->
        </div>
    </div>

@endsection
