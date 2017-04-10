<!-- 
	/*
	 * For getting the posts from postTable in MySQL.
	 * 
	 * $id = post id for which user has to edit the post
	 *
	*/
 -->

<?php
	
	include "config.php";
	
	$id= $_POST["edit_id"];
	
	if($id != NULL){
		$sql ="SELECT post FROM postTable WHERE pid='$id'";
		$result=$conn->query($sql);
		$post = $result->fetch_assoc()["post"];
		echo $post;	
	}
	
?>
