<!-- 
	/*
	 * For accepting and rejecting friend requests.
	 * 
	 * $accept_id = ID of the user whose friend request has been accepted
	 * $decline_id = ID of the user whose friend request has been rejected
	 *
	*/ 
-->

<?php

	include 'config.php';
	include 'navHeader.php';
	include 'resources.php';
	
	
	session_start();
	$uid=$_SESSION['id'];

/*
 * Name: acceptRequests
 * 
 * This function connects to the database and gets the value of the request status 
 * Based on the request status: 
 *			if 1 => displays accept or decline buttons
 *			if 2 => displays that they are now friends
 * 
 * Params:
 *		$conn 	MySQL connection
 *		$uid 	ID of the user
 *
*/

	function acceptRequests($conn,$uid){	
		$sql = "SELECT users.user_name,Requests.from_id
		FROM users
		JOIN Requests 
		ON Requests.from_id = users.id WHERE Requests.to_id = '$uid'";
		$result= $conn->query($sql);

		$json_username=array();
		$json_id=array();


		while($row=$result->fetch_assoc()){
			array_push($json_username,$row['user_name']);
			array_push($json_id,$row['from_id']);
		}


		for ($i=0; $i<count($json_username); $i++){
			$sql="SELECT request_status FROM Requests WHERE to_id='$uid' AND from_id='$json_id[$i]'";
			$result =$conn->query($sql);
			if($result->num_rows>0){
				if (($result->fetch_assoc()['request_status']) === '1'){
					echo '<div style="font-size:25px" class="col-md-5 col-md-offset-3" >'.$json_username[$i].
							'</br><a href=friend_requests.php?accept_id='.urlencode($json_id[$i]).'>
								<button name="accept" class="btn btn-primary"> Accept</button>
							</a>
							<a href=friend_requests.php?decline_id='.urlencode($json_id[$i]).'>
								<button  name="decline" class="btn btn-default"> Decline </button>
							</a>
						</div></br>';	
				}
				else if (($result->fetch_assoc()['request_status']) === '2'){
					echo '<div style="font-size:25px" class="col-md-5 col-md-offset-3" >'.$json_username[$i].
							'</br><p> You are now friends</p>
						</div></br>';	
				}
			}
		}
	}
			
	if(isset($_GET['accept_id'])){
		$from_id=$_GET['accept_id'];
		$sql = "UPDATE Requests SET request_status='2' WHERE from_id='$from_id' AND to_id='$uid'";
		$result =$conn->query($sql);
	}


	if(isset($_GET['decline_id'])){
		$from_id=$_GET['decline_id'];
		$sql = "UPDATE Requests SET request_status='0' WHERE from_id='$from_id' AND to_id='$uid'";
		$result =$conn->query($sql);
	}

	if(isset($_POST["logout"])){
	session_destroy();
	header('Location:loginForm.php');
	exit();
	}
acceptRequests($conn,$uid);

?>

