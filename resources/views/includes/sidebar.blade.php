
<div class="sidebar" data-color="green">
    <div class="sidebar-wrapper">
        <ul class="nav">

            <li class="active">
                <a href="{{ url('/addExpense') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Add Expense</p>
                </a>
            </li>

            <li>
                <!-- redirects to profile page based on username -->
                <a href="../profile/{{ Auth::user()->username }}">
                    <i class="material-icons">face</i>

                    <p>User Profile</p>
                </a>
            </li>

            <li>
                <a href="{{ url('/tableList') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Table List</p>
                </a>
            </li>
            <li>
                <a href="{{ url('/search') }}">
                    <i class="material-icons">today</i>
                    <p>Add Friend</p>

                </a>
            </li>

            <li>

                <a href="{{ url('/statistics') }}">
                    <i class="material-icons">library_books</i>
                    <p>Statistics</p>
                </a>
            </li>
        </ul>
    </div>
</div>
