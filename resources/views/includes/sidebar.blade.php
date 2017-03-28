
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
                <a href="./profile/{{ Auth::user()->username }}">
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
