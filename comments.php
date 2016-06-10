<?php

include 'config.php';
$comment =$_POST['comment'];
$pid= $_POST['pid'];
$uid= $_POST['user_id'];

echo $comment, $pid, $uid;
$sql ="INSERT INTO commentTable (comment, pid, uid) VALUES ('$comment','$pid','$uid')";
$result= $conn->query($sql);
?>
