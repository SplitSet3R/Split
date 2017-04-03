
<div class="sidebar" data-color="green">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="active">
                <a href="/dashboard">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
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
                <a href="">
                    <i class="material-icons">content_paste</i>
                    <p>Table List</p>
                </a>
            </li>
            <li>

                <a href='/search'>
                    <i class="material-icons">library_books</i>
                    <p>Add Friend</p>
                </a>
            </li>
            <li>
                <a href="/friends">
                    <i class="material-icons">content_paste</i>
                    <p>Friends List</p>
                </a>
            </li>
            <li>
                <a href="/groups">
                    <i class="material-icons">group</i>
                    <p>Groups</p>
                </a>
            </li>

        </ul>
    </div>
</div>
