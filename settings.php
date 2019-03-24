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
$details=userDetails($conn,$uid);

echo '
<div class="container" style="padding-top:70px">
	<div class="row"  style="border-style: outset;">
		<div class="col-md-3 scrollBarBackground">
			<ul>
			  <a href="settings.php" style="text-decoration:none;"><li class="scrollBarText scrollActive">Edit Profile</li></a>
			  <a href="updatePassword.php" style="text-decoration:none;"><li class="scrollBarText">Change Password</li></a>
			  <a href="uploadProfilePic.php" style="text-decoration:none;"><li class="scrollBarText">Upload Profile Picture</li></a>
			</ul>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-3">
			 		<img src="profile_pics/'.$details[6].'" class="img-circle" alt="Cinque Terre" width="100" height="100">
			 	</div>
			 	<div class="col-md-6">
					<h2>Majeti Srividya</h2>
				</div>
			</div>
			</br>
			<div class="row" style="padding-left: 40px;padding-bottom:20px;">
				<form action="insertUserDetails.php" method="post">
	                <div class="form-group">
	                    <label>First Name</label>
	                    <input class="form-control" name="fname" placeholder="Enter text" value="'.$details[0].'">
	                </div>
	                <div class="form-group">
	                    <label>Last Name</label>
	                    <input class="form-control" name="lname" placeholder="Enter text" value="'.$details[1].'">
	                </div>
	                <div class="form-group">
	                    <i class="fa fa-female" aria-hidden="true"></i> <i class="fa fa-male" aria-hidden="true"></i><label><tab>Gender</tab></label>
	                     <select class="form-control" name="sex">
	                     	<option value="" disabled selected>Select your option</option>
	                        <option>Female</option>
	                        <option>Male</option>
	                        <option>Not Specified</option>
	                    </select>
	                </div>
	                <div class="form-group">
	                    <i class="fa fa-phone" aria-hidden="true"></i><label><tab>Phone Number</tab></label>
	                    <input class="form-control" name="phone" value="'.$details[4].'" placeholder="+1(999)-999-9999">
	                    <span class="help-block">Optional</span>
	                </div>
	               <div class="form-group">
					  <i class="fa fa-glass" aria-hidden="true"></i><label for="example-date-input"><tab>Birthday</tab></label>
					  <div>
					    <input class="form-control" name="birthday" type="date" value="'.$details[5].'" id="example-date-input">
					  </div>
					</div>
	                <div class="form-group">
	                     <i class="fa fa-calendar" aria-hidden="true"></i><label><tab>Age</tab></label>
	                    <input class="form-control" name="age" value="'.$details[2].'" placeholder="25" style="width: 10%">
	                </div>
	                <button class="btn btn-primary">
						<i class="fa fa-upload" aria-hidden="true"></i>
						Submit
					</button>
				</form>
            </div>
		</div>
	</div>									
</div>
<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
';

?>
