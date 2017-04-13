
<div class="sidebar" data-color="green">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li id="colorDashboard">
                <a href="/dashboard">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li id="colorProfile">
                <!-- redirects to profile page based on username -->
                <a href="../profile/{{ Auth::user()->username }}">
                    <i class="material-icons">face</i>
                    <p>User Profile</p>
                </a>
            </li>
            <li id="colorNotifications">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="notifications-toggle">
                    <i class="material-icons">notifications_active</i>
                    <p>Notifications</p>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" id="dropdown-notifications">



                </ul>
                <script>
                    $(document).ready(function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/notifications',
                            data: {},
                            dataType: 'json',
                            success: function (data) {
                                if(data["requestnotifications"].length > 0) {
                                    for(var i=0; i<data["requestnotifications"].length; i++) {
                                        var newreq = document.createElement('LI');
                                        newreq.innerHTML = data["requestnotifications"][i]['message'];
                                        document.getElementById('dropdown-notifications').append(newreq);
                                    }
                                } else {
                                    var noreq = document.createElement('LI');
                                    noreq.innerHTML = "no notifications";
                                    document.getElementById('dropdown-notifications').append(noreq);
                                }
                            }
                        });
                    });
                    /*
                    $('#notifications-toggle').on('click', function(e){
                        //set all to viewed
                        $.ajax({
                            type: 'POST',
                            url: '/notifications',
                            data: {}, //Data values are reference ids
                            dataType: 'json',
                            success: function (data) {

                            }
                        });
                    });*/
                </script>
            </li>
            <li id="colorAddFriend">
                <a href='/search'>
                    <i class="material-icons">library_books</i>
                    <p>Add Friend</p>
                </a>
            </li>
            <li id="colorFriendsList">
                <a href="/friends">
                    <i class="material-icons">content_paste</i>
                    <p>Friends List</p>
                </a>
            </li>
            <li id="colorGroups">
                <a href="/groups">
                    <i class="material-icons">group</i>
                    <p>Groups</p>
                </a>
            </li>
        </ul>
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

            <form id="expForm" action="/{{ Auth::user()->username }}/addexpense" method="POST" class="form-horizontal" autocomplete="on">
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
                    <input type="submit" placeholder="Submit" id="expSubmit" name="newExpBtn" class="btn btn-success openAddExpenseModal">
                    <button type="button" id="closeAddExpenseBtn" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
  @if (count($errors) > 0)
      $('#addExpenseModal').modal('show');
      @if($errors->has('expOwedAmount') || $errors->has('username'))
        $("#owedButton").click();
      @endif
  @endif

  $(document).ready(function() {
      var currentUrl = window.location.pathname;
      // add more url's here when needed
      var dashboard = "/dashboard";
      var profile = "/profile/{{ Auth::user()->username }}";
      var notifications = "/notifications";
      var addFriend = "/search";
      var friends = "/friends";
      var groups = "/groups";

      // sidebar will highlight based on current page
      switch(currentUrl) {
          case dashboard:
              $('#colorDashboard').addClass('active');
              break;
          case profile:
              $('#colorProfile').addClass('active');
              // added this here because the text on user profile would persist as gray even when clicked on
              $('#colorProfile a i').css('color', 'white');
              $('#colorProfile a p').css('color', 'white');
              break;
          case notifications:
              $('#colorNofications').addClass('active');
              break;
          case addFriend:
              $('#colorAddFriend').addClass('active');
              break;
          case friends:
              $('#colorFriendsList').addClass('active');
              break;
          case groups:
              $('#colorGroups').addClass('active');
              break;
          default:
              $('#colorDashboard').addClass('active');
      }
  });
</script>
