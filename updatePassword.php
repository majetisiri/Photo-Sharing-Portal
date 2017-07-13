<?php

include 'functions.php';
include 'navHeader.php';

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


postModal($postErr);
userDetails($conn,$uid);

echo '
<div class="container" style="padding-top:70px">
	<div class="row"  style="border-style: outset;">
		<div class="col-md-3 scrollBarBackground">
			<ul>
			  <a href="settings.php" style="text-decoration:none;"><li class="scrollBarText">Edit Profile</li></a>
			  <a href="updatePassword.php" style="text-decoration:none;"><li class="scrollBarText scrollActive">Change Password</li></a>
			  <a href="uploadProfilePic.php" style="text-decoration:none;"><li class="scrollBarText">Upload Profile Picture</li></a>
			</ul>
		</div>
		</br>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-3">
			 		<img src="https://s-media-cache-ak0.pinimg.com/originals/04/e3/ae/04e3ae50ebcbf5a0473b166e95cb433b.jpg" class="img-circle" alt="Cinque Terre" width="100" height="100">
			 	</div>
			 	<div class="col-md-6">
					<h2>Majeti Srividya</h2>
				</div>
			</div>
			</br>
			<div class="row" style="padding-left: 40px;padding-bottom:20px;">
                <div class="form-group">
                    <label>Old Password</label>
                    <input class="form-control" type="password" placeholder="Enter text">
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input class="form-control" type="password" placeholder="Enter text">
                </div>
                <div class="form-group">
                    <label>Re-enter New Password</label>
                    <input class="form-control" type="password" placeholder="Enter text">
                </div>
                <button class="btn btn-primary">
					<i class="fa fa-upload" aria-hidden="true"></i>
					Update
				</button>
            </div>
		</div>
	</div>									
</div>
<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
';

?>
