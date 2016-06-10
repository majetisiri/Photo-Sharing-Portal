<?php
	include 'config.php';
	session_start();
	$uid=$_SESSION['id']; 
	//echo $uid;
	
include 'navHeader.php';
include 'mutual_friends.php';

function sendRequests($conn,$uid){	
	
	//echo $uid;

	$sql ="SELECT user_name,id 
	FROM users 
	WHERE id!='$uid' AND id NOT IN(
		SELECT from_id from Requests Where to_id='$uid'
		UNION
		SELECT to_id from Requests Where from_id='$uid')";
	//echo $sql;
	$result = $conn->query($sql);
	$json_user_name=array();
	$json_id=array();
	

	while($row=$result->fetch_assoc()){
		array_push($json_user_name,$row['user_name']);
		array_push($json_id,$row['id']);
		//echo "im here";
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
			echo '<div class="col-md-5 col-md-offset-3 row"><a href="friends.php?add_id='.urlencode($json_id[$i]).'">
					<button class="btn btn-primary">Add Friend</button>
				</a>
				<a href="friends.php?remove_id='.urlencode($json_id[$i]).'">
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
			//echo 'hello';
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
	 		//echo 'hello';
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