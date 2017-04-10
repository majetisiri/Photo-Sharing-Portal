<!--
	 /*
	 * For updating a post by the user from the postTable in MySQL.
	 * 
	 * $id = post ID which user wants to update
	 *
	*/ 
-->

<?php 

	include "database/QueryBuilder.php";
	
	$id= $_POST["edit_id"];
	$post = $_POST['post_data'];
	
	if($id != NULL && $post!=NULL) {
		$result= QueryBuilder:: updatePost($conn,$post,$id);	
		echo $result;
	}

?>