<!--
     /*
     * Navbar on the top of the App
    */ 
-->


<style>
a{
	cursor: pointer;
}
</style>

<nav class="navbar navbar-inverse bg-inverse" role="navigation">
    <div class="navbar-header" id="two">
        <a class="navbar-brand" href="page.php">Photo Sharing Portal</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="active" id="three">
                <a class="nav-link" href="myPage.php">
                    <i class="fa fa-home" aria-hidden="true"></i> My Profile
                </a>
            </li>
            <li id="four">
                <a class="nav-link" href="find_friends.php">
                    <i class="fa fa-users" aria-hidden="true"></i> Find Friends
                </a>
            </li>
            <li id="five">
                <a class="nav-link" href="friend_requests.php">
                    <i class="fa fa-male" aria-hidden="true"></i> Friend Requests
                </a>
            </li>
        </ul>
         <div class="col-sm-3 col-md-3">
            <form class="navbar-form" role="search">
                <div style="width:100%;" class="input-group">
                    <form class="form-inline" method="post" action="search.php">
                        <input type="text" class="form-control search_text" placeholder="Search for friends" name="search_data" />
                    </form>
                </div>
            </form>
        </div>
        <div style="margin-top:8px;" class="pull-right">
            <button id="six" class="btn btn-primary" data-toggle="modal" data-target="#postModal">
                <i class="fa fa-pencil" aria-hidden="true"></i> Post
            </button>
            <a href="logout.php">
                <button id="seven" class="btn btn-danger">
                    <i class="fa fa-power-off" aria-hidden="true"></i> Logout
                </button>
            </a>
            <a href="settings.php">
                <button id="eight" class="btn btn-default">
                    <i class="fa fa-cog" aria-hidden="true"></i> Settings
                </button>
            </a>
        </div>
       
    </div>
</nav>
