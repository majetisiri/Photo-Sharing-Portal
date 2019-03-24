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
seamlessResponsive($conn,$uid);
commentsModal($conn);

echo '
<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
';

?>
