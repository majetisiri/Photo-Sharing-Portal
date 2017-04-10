<!-- 
	/*
	 * For adding or removing friends. 
	 * Initially displays all the users in the app with whom you are not friends with.
	 * 
	 * $add_id = ID of the user for whom you sent the friend request for
	 * $remove_id = ID of the user whom you removed
	 *
	*/ 
-->


<?php
	include 'config.php';
	include 'resources.php';
	include 'navHeader.php';
	include 'mutual_friends.php';

session_start();

$uid=$_SESSION['id']; 
	

/*
 * Name: sendRequests
 * 
 * This function connects to the database and gets all the users with whom you are not friends with
 *
 * Params:
 *		$conn 	MySQL connection
 *		$uid 	ID of the user
 *
*/

function sendRequests($conn,$uid){	
	
	$sql ="SELECT user_name,id 
	FROM users 
	WHERE id!='$uid' AND id NOT IN(
		SELECT from_id from Requests Where to_id='$uid'
		UNION
		SELECT to_id from Requests Where from_id='$uid')";
	
	$result = $conn->query($sql);
	$json_user_name=array();
	$json_id=array();
	

	while($row=$result->fetch_assoc()){
		array_push($json_user_name,$row['user_name']);
		array_push($json_id,$row['id']);
	}

	$profid=0;

	for ($i=0; $i<count($json_user_name);$i++){
		if($result->num_rows>0){
			echo '
			<div style="font-size:25px" class="col-md-5 col-md-offset-3 row">'
				.ucwords($json_user_name[$i]).
			'</div>';
			$profid = $json_id[$i];
			mutualFriends($uid,$profid);
			echo '<div class="col-md-5 col-md-offset-3 row"><a href="find_friends.php?add_id='.urlencode($json_id[$i]).'">
					<button class="btn btn-primary">Add Friend</button>
				</a>
				<a href="find_friends.php?remove_id='.urlencode($json_id[$i]).'">
					<button name="remove" class="btn btn-danger">Remove</button>
				</a>
			</div>';
		}
	}
}



if(isset($_GET['add_id'])){
	$to_id = $_GET['add_id'];
	$sql= "SELECT from_id, to_id FROM Requests WHERE from_id='$uid' AND to_id = '$to_id'" ;
	$result =$conn->query($sql);
	if($result ->num_rows==0){
		$sql="INSERT INTO Requests (from_id,to_id,request_status) VALUES('$uid','$to_id','1')";
		if($conn->query($sql) ===TRUE){
		}	
	} 
	
}


if(isset($_GET['remove_id'])){
	$to_id = $_GET['remove_id'];
	$sql= "SELECT from_id, to_id FROM Requests WHERE from_id='$uid' AND to_id='$to_id'";
	$result =$conn->query($sql);
	if($result->num_rows==0){
	 	$sql="INSERT INTO Requests (from_id,to_id,request_status) VALUES('$uid','$to_id','0')";
	 	if($conn->query($sql) ===TRUE) {
	 	}
	 }
}

if(isset($_POST["logout"])){
	session_destroy();
	header('Location:loginForm.php');
	exit();
	}

sendRequests($conn,$uid);
?>