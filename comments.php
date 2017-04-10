<!--
	 /*
	 * For inserting the comments posted by the user into the commentTable in MySQL.
	 * 
	 * $comment = comment posted by the user
	 * $pid = post id for which user commented on
	 * $user_id = ID of the user
	 *
	*/ 
-->


<?php

include 'config.php';
// include 'database/QueryBuilder.php';

$comment =$_POST['comment'];
$pid= $_POST['pid'];
$uid= $_POST['user_id'];

echo $comment, $pid, $uid;

$sql ="INSERT INTO commentTable (comment, pid, uid) VALUES ('$comment','$pid','$uid')";
$result= $conn->query($sql);
?>
