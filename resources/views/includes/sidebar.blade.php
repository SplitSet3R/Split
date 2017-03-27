
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="active">
                <a href="dashboard.html">
                    <i class="material-icons">dashboard</i>
                    <p>add Expense</p>
                </a>
            </li>
            <li>
                <a href="">
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
                <a href="">
                    <i class="material-icons">library_books</i>
                    <p>add friend</p>
                </a>
            </li>
            <li>
                <!-- Testing notifications here -->
                <a href="#expenseNotifications" data-toggle="collapse">
                    <i class="material-icons">content_paste</i>
                    <p>Expense Notifications</p>
                </a>
                <div class="collapse" id="expenseNotifications">
                    <ul>
                        @foreach($expenseNotifications as $expenseNotification)
                            <li>{{$expenseNotification[1]}}</li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li>
                <!-- Testing notifications here -->
                <a href="#friendNotifications" data-toggle="collapse">
                    <i class="material-icons">content_paste</i>
                    <p>Friend Notifications</p>
                </a>
                <div class="collapse" id="friendNotifications">
                    <ul>
                        @foreach($friendNotifications as $friendNotification)
                            <li>{{$friendNotification[1]}}</li>
                        @endforeach
                    </ul>
                </div>
            </li>

        </ul>
    </div>
