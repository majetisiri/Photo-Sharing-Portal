<?php

include 'resources.php';
include 'functions.php';
include 'config.php';

session_start();

$uid = $_SESSION['id'];

$postErr = "";
if(isset($_POST["post_data"]) && isset($_FILES['fileToUpload'])){
	$file_new_name = fileupload();
	$post =$_POST["post_data"];
	if($post!= NULL && $file_new_name!= NULL){
		$uid= $_SESSION['id'];
		
		$result= QueryBuilder::insertPost($conn,$post, $file_new_name, $uid);
	}
	else{
		$postErr = "No post";
	}
	
}


echo '
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
         <div style="margin-top:8px;"class="pull-right">
			<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				Post
			</button>
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

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Attach Image, write description & POST!!</h4>
        </div>
        <div class="modal-body">
        <form action="#" method="post" enctype="multipart/form-data">
			<textarea class="form-control" rows="5" cols="90" name="post_data" placeholder="write your post here"></textarea> 
			<div class="help-block with-errors" style="color:red;">'.$postErr .'</div>
			<div class="row">
				<div class="col-md-4"> 
					<input type="file" name="fileToUpload" id="fileToUpload"> 
				</div>
				<div class="col-md-3 pull-right">
					 <button name="submit" type="submit" class="btn btn-primary pull-right"> 
					 	<i class="fa fa-pencil" aria-hidden="true"></i>
					 	Post  
					 </button>
				</div>
			</div>
		</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
';

seamlessResponsive($conn,$uid);
?>
