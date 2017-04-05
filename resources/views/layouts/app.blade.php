<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->



    <link rel="stylesheet" href="{{ asset('css/common/split.css')}}">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet" />



    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" style="color:black;font-size:43px;font-family:courier;" href="{{ url('/') }}">
                        {{ config('app.name', 'Split') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else

                            <li class=".addExdansebtn"><button class="btn btn-danger openAddExpenseModal" data-toggle="modal" data-target="#addExpenseModal">
                                    Add Expense</button>&nbsp &nbsp</li>
                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>

                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="wrapper">
        @yield('styles')
          @if(Auth::check())
            @include('includes.sidebar')
          @endif
        @yield('content')
      </div>
    </div>
    @if(Auth::check())
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
    @endif

    <!-- Custom Scripts -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{asset('js/include/underscore-min.js')}}"></script>
    @yield('scripts')
</body>
</html>
