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

include 'database/QueryBuilder.php';

$comment =$_POST['comment'];
$pid= $_POST['pid'];
$uid= $_POST['user_id'];


QueryBuilder:: insertComments($conn, $comment, $pid, $uid);
?>
