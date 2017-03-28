
<div class="sidebar" data-color="green">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="active">
                <a class="openAddExpenseModal" data-toggle="modal" data-target="#addExpenseModal">
                    <i class="material-icons">dashboard</i>
                    <p>Add Expense</p>
                </a>
            </li>
            <li>
                <!-- redirects to profile page based on username -->
                <a href="../profile/{{ Auth::user()->username }}">
                    <i class="material-icons">person</i>
                    <p>User Profile</p>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="material-icons">content_paste</i>
                    <p>Table List</p>
                </a>
            </li>
            <li>

                <a href='/friends/search'>
                    <i class="material-icons">library_books</i>
                    <p>Add Friend</p>
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
