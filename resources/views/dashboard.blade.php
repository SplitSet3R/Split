@extends('layouts.app')
@section('content')


    <div class="main-panel">
        <div class="col-sm-7">
          <h4>{{ Auth::user()->firstname}}'s expenses</h4>
          <div>
            <h2>Summary of Expenses</h2>
              <table class='table' id="displayTable">
                <thead>
                  <tr><th>OWED</th><th>OWES</th><th>TTL</th><th>BAL</th></tr></thead>
                  <tbody><tr><td class='text-success'><strong>+0</strong></td><td class='text-danger'><strong>-0</strong></td><td>0</td><td>0</td></tr></tbody>
              </table>
          </div>
        </div>
        <div class="col-sm-7">
              <div class='container'>
                <h2>Outstanding Expenses</h2>
                <table class='table' id='displayTable'>
                    <thead class='thead-default'>
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
                      <th>Type<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Date<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Amount<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Balance<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Shared with<i class='fa fa-sort' aria-hidden='true'></i></th>
                      <th>Comments<i class='fa fa-sort' aria-hidden='true'></i></th>
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
              <!--<script>$('table').tablesort();</script>-->
        </div>
    </div>

@endsection
