<?php
	
	include "config.php";
	
	session_start();
	$id= $_GET["edit_id"];
	
	
	if($id != NULL){
		$sql ="SELECT post FROM postTable WHERE pid='$id'";
		$result=$conn->query($sql);
		$post = $result->fetch_assoc()["post"];
	}

	
	echo "
	<div class='col-md-4 col-md-offset-3 row'>
		<form action='#'' method='POST'>
			<textarea rows='5' cols='70' name='post_data'> ".$post."</textarea><br/><br/>
			<button name='re_post' type='submit' class='btn btn-primary'> Re-Post </button>
		</form>
	</div>";
	
	if(isset($_POST['re_post'])){
		$post = $_POST['post_data'];
		echo $post;
		$sql = "UPDATE postTable SET post='$post' WHERE pid='$id'";
		$result= $conn->query($sql);
		if(isset($result)){
			header('Location:page.php');
		}
	}

	
?>
