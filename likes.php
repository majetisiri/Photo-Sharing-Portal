<!--
	 /*
	 * For updating the likes count posted by the user for each post in likeTable in MySQL.
	 * 
	 * $pid = post id for which user liked 
	 * $user_id = ID of the user who liked the post 
	 *
	*/ 
-->

<?php

include 'config.php';

$pid=$_POST['pid'];
$uid=$_POST['user_id'];

$sql="SELECT like_count from likeTable where pid='$pid' And uid='$uid'";
$result=$conn->query($sql); 
print_r($result);
if($result->num_rows>0){
	if ($result->fetch_assoc()['like_count']==0){
		$sql="UPDATE likeTable Set like_count='1' WHERE pid='$pid' And uid='$uid'";
	}
	else{
		$sql="UPDATE likeTable Set like_count='0' WHERE pid='$pid' And uid='$uid'";	
	}	
}
else{
	$sql="INSERT INTO likeTable  (like_count,pid,uid) values (1,'$pid','$uid')";

}
$result=$conn->query($sql); 



print_r($result);

?> 