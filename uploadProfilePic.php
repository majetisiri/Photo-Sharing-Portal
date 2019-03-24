<?php

include 'functions.php';
include 'navHeader.php';

session_start();

$uid = $_SESSION['id'];

$postErr = "";
if(isset($_FILES['profilePicUpload'])){
	$file_new_name = profilePicUpload();
	echo $file_new_name;
	if($file_new_name!= NULL){
		$uid= $_SESSION['id'];
		
		$result= QueryBuilder::insertProfilePic($conn,$file_new_name, $uid);
		echo $result;
	}
	
}


postModal($postErr);
$details=userDetails($conn,$uid);

echo '
<div class="container" style="padding-top:70px">
	<div class="row"  style="border-style: outset;">
		<div class="col-md-3 scrollBarBackground">
			<ul>
			  <a href="settings.php" style="text-decoration:none;"><li class="scrollBarText">Edit Profile</li></a>
			  <a href="updatePassword.php" style="text-decoration:none;"><li class="scrollBarText">Change Password</li></a>
			  <a href="uploadProfilePic.php" style="text-decoration:none;"><li class="scrollBarText scrollActive">Upload Profile Picture</li></a>
			</ul>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-3">
			 		<img src="profile_pics/'.$details[6].'" class="img-circle" alt="Prof_pic not found" width="100" height="100">
			 	</div>
			 	<div class="col-md-6">
					<h2>Majeti Srividya</h2>
				</div>
			</div>
			</br>

			<form action="#" method="post" enctype="multipart/form-data">
				<div class="row col-md-offset-3">
					<label>Upload Profile Picture</label><br><br>
					<img src="./images/upload.png" width="80px" length="80px" style="padding-bottom:10px;"">
					<input type="file" name="profilePicUpload" id="profilePicUpload"> <br>
					 <button name="submit" type="submit" class="btn btn-primary"> 
					 	<i class="fa fa-pencil" aria-hidden="true"></i>
					 	Upload 
					 </button>
				</div>
			</form>
		</div>
	</div>									
</div>
<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
';

?>
