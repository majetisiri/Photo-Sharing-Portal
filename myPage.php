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
$result = QueryBuilder::getUserDetails($conn,$uid);
$row= $result->fetch_assoc();
echo '
  <div class="row">
    <div class="col-md-2 col-md-offset-1">
    <h3>'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</h3>
    <img class="img-circle" src="'.$row['profile_pic'].'" width="200px" height="200px">
    <br><br><br><i>
    <p><i class="fa fa-phone" aria-hidden="true"></i> '.$row['phone'].'</p>
    <p><i class="fa fa-home" aria-hidden="true"></i> '.$row['address'].'</p>
    <p><i class="fa fa-glass" aria-hidden="true"></i> '.$row['birthday'].'</p>
    <p><i class="fa fa-building" aria-hidden="true"></i> '.$row['office'].'</p>
    <p><i class="fa fa-male" aria-hidden="true"></i><i class="fa fa-female" aria-hidden="true"></i> '.$row['sex'].'</p>
    <p><i class="fa fa-calendar" aria-hidden="true"></i> '.$row['age'].'</p>
    <p><i class="fa fa-pencil" aria-hidden="true"></i> '.$row['email'].'</p></i>
  </div>
    <div class="col-md-8">';
            myPageSeamlessResponsive($conn,$uid);
echo '</div>
<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>

';

?>