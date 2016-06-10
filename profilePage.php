
<?php

include 'navHeader.php';
include 'mutual_friends.php';
include 'displayPosts.php';


$uid = "";

if(isset($_GET['uid'])){
	$uid = $_GET['uid'];
	$sql="SELECT user_name FROM users where id='$uid'";
	$result=$conn->query($sql);
	$username=$result->fetch_assoc()['user_name'];

	echo '
	<div class="col-md-5 col-md-offset-3 row">
		<p style="font-size:40px;">
			Welcome to '.ucwords($username).'"s page
		</p>
	</div>
	<div class="col-md-5 col-md-offset-3 row">
		<img src="uploads/5755b5a0e8fc16.19720630.jpeg" width="120px" height="120px" />
	</div>';

		mutualFriends($uid,$profid);	
}

displayPosts($conn,$uid) ;
?>
