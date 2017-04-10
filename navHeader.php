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
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Photo Sharing Portal</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="active">
            	<a class="nav-link" href="page.php">
            		<i class="fa fa-home" aria-hidden="true"></i>
					Home
				</a>
            </li>
            <li>
            	<a class="nav-link" href="find_friends.php">
					<i class="fa fa-users" aria-hidden="true"></i>
            		Find Friends
            	</a>
            </li>
            <li>
            	<a class="nav-link" href="friend_requests.php">
            		<i class="fa fa-male" aria-hidden="true"></i>
            		Friend Requests
            	</a>
            </li>
        </ul>
        <div style="margin-top:8px;"class="col-md-1 col-sm-1 pull-right">
        	<a href="logout.php">
        		<button class="btn btn-danger">
					<i class="fa fa-power-off" aria-hidden="true"></i>
					Logout
				</button>
			</a>
        </div>
        <div class="col-sm-3 col-md-3 pull-right">
            <form class="navbar-form" role="search">
                <div style="width:100%;" class="input-group">
			 		<form class="form-inline" method="post" action="search.php">
                  		<input type="text" class="form-control search_text" placeholder="Search for friends" name="search_data"/>
                  	</form>
                </div>
            </form>
        </div>        
    </div>
</nav>
