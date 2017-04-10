<!-- 
	/*
	 * For getting the comments for each post from commentTable in MySQL.
	 * 
	 * $pid = post id
	 *
	*/
 -->

<?php

	include 'config.php';
	
	$pid = $_POST['pid'];
	
 	

	$sql = "SELECT comment from commentTable where pid='$pid'";
 	$result= $conn->query($sql);
 	$json_comment=array();
 	while($row= $result->fetch_assoc()){
 		array_push($json_comment,$row['comment']);
 	}

 	print_r(json_encode($json_comment));

?>