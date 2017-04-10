<!--
	 /*
	 * For deleting a post by the user from the postTable in MySQL.
	 * 
	 * $delete_id = post id which user wants to delete
	 *
	*/ 
-->

<?php
	
	include 'database/QueryBuilder.php';
	

	$delete_id = $_POST['delete_id'];

	$result= QueryBuilder::deletePost($conn, $delete_id);
	print_r($result);
	if(!$result) {
		echo "Error: " . $sql . "<br>" . $conn->error;	
	}

	echo true;

?>