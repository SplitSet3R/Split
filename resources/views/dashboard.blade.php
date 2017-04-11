@extends('layouts.app')
@section('content')
    <div class="main-panel">
        <div class="container-fluid">
          <h4>{{ Auth::user()->firstname}}'s expenses</h4>
          <div>
              <table class='table'>
                <thead>
                  <tr><th>OWED</th><th>OWES</th><th>TTL</th><th>BAL</th></tr></thead>
                  <tbody><tr><td class='text-success'><strong>+0</strong></td><td class='text-danger'><strong>-0</strong></td><td>0</td><td>0</td></tr></tbody>
              </table>
          </div>
        </div>
        <div class="col-sm-9">
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

@endsection
