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
session_start();

$uid = $_SESSION['id'];
$fname =$_POST['fname'];
$lname= $_POST['lname'];
$sex= $_POST['sex'];
$phone =$_POST['phone'];
$birthday= $_POST['birthday'];
$age= $_POST['age'];


QueryBuilder::insertUserDetails($conn, $fname, $lname, $sex, $phone,$birthday,$age,$uid);
?>
