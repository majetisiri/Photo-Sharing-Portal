<?php
include "config.php";

class QueryBuilder{
	// write a cnstructor which calls the function connectiondb in functions.php
	public function selectEmailID($conn,$uid,$emailID){
		$sql = "SELECT email FROM users WHERE email='$emailID'";
		$result= $conn->query($sql);
		return $result;
	}

	public function insertNewUserCredentials($conn,$name,$emailID,$password){
		$sql = "INSERT INTO users (user_name, email, password) VALUES ('$name', '$emailID',  '$password')";
		$result= $conn->query($sql);
		return $result;
	}
	
	public function insertUserDetails($conn, $fname, $lname, $sex, $phone,$birthday,$age,$uid){
		$result= QueryBuilder::getUserDetails($conn,$uid);
		if($result->num_rows>0){
			$sql= "UPDATE userDetails SET first_name='$fname',last_name='$lname',age='$age',sex='$sex',phone='$phone',birthday='$birthday',uid='$uid' WHERE uid='$uid'";
			$result= $conn->query($sql);
		}
		else{
			$sql = "INSERT INTO userDetails (first_name, last_name,sex,phone,birthday,age,uid) VALUES ('$fname', '$lname', '$sex', '$phone','$birthday','$age','$uid')";
			$result= $conn->query($sql);
		}
		
	}

	public function getUserDetails($conn,$uid){
		$sql="SELECT * FROM userDetails WHERE uid='$uid'";
		$result= $conn->query($sql);
		return $result;
	}

	public function selectUserDetailsForLogin($conn,$emailID,$password){
		$sql= "SELECT id FROM users WHERE email ='$emailID' and password='$password'";
		$result = $conn-> query($sql);
		return $result;
	}


	public function getUsername($uid){
		$sql="SELECT user_name FROM users where id='$uid'";
		$result=$conn->query($sql);
		return $result;
	}

	public function insertPost($conn,$post, $file_new_name, $uid){
		$sql ="INSERT INTO postTable (post,image_name,uid) VALUES ('$post','$file_new_name','$uid')";
		$result= $conn->query($sql);
		return $result;
	}

	public function getPost($id){
		$sql ="SELECT post FROM postTable WHERE pid='$id'";
		$result=$conn->query($sql);
 		return $result;
	}

	public function updatePost($conn,$post,$id){
		$sql = "UPDATE postTable SET post='$post' WHERE pid='$id'";
		$result = $conn->query($sql);
 		return $result;
	}
	
	public function insertLikeStatus($conn, $pid, $uid){
		$sql ="INSERT INTO likeTable  (like_count,pid,uid) values (1,'$pid','$uid')";
		$result= $conn->query($sql);
		return $result;
	}

	public function getLikeStatus($conn,$pid, $uid){
		$sql ="SELECT like_count from likeTable where pid='$pid' And uid='$uid'";
		$result=$conn->query($sql);
 		return $result;
	}

	// public function getLikeCount($conn,$pid){
	// 	$sql = "SELECT sum(like_count) as l from likeTable where pid='$pid'";
	// 	$result= $conn->query($sql);
	// 	return $result;
	// }

	public function updateLikeStatus($conn, $pid, $uid){
		$sql = "UPDATE likeTable Set like_count='1' WHERE pid='$pid' And uid='$uid'";
		$result = $conn->query($sql);
 		return $result;
	}

	public function updateUnlikeStatus($conn,  $pid, $uid){
		$sql = "UPDATE likeTable Set like_count='0' WHERE pid='$pid' And uid='$uid'";
		$result = $conn->query($sql);
 		return $result;
	}

	public function deletePost($conn, $delete_id){
		$sql = "DELETE from postTable where pid='$delete_id'";
		$result = $conn->query($sql);
		return $result;

	}

	public function insertComments($conn,$comment, $pid, $uid){
		$sql ="INSERT INTO commentTable (comment, pid, uid) VALUES ('$comment','$pid','$uid')";
		$result= $conn->query($sql);
	}

	public function getComment($pid){
		$sql = "SELECT comment from commentTable where pid='$pid'";
 		$result= $conn->query($sql);
 		return $result;
	}

	public function selectPostsOfAllUsers($conn,$uid){
		$sql = "SELECT post,id,pid,image_name,user_name 
				FROM postTable 
				JOIN users 
				ON postTable.uid=users.id
						where uid in 
							(SELECT to_id from Requests 
							join users 
							on Requests.from_id='$uid' and request_status='2'
			 				union
			 				SELECT from_id from Requests
			 				join users on
			 				Requests.to_id='$uid' and request_status='2')
						or uid= '$uid'";

		$result = $conn->query($sql);
		return $result;
	}

	public function selectAllPostsOfUser($conn,$uid){
		$sql = "SELECT post,id,pid,image_name,user_name 
				FROM postTable 
				JOIN users 
				ON postTable.uid=users.id
				WHERE users.id='$uid'";
		$result = $conn->query($sql);
		return $result;
	}

	public function selectMutualFriends($uid, $profid){
		$sql="SELECT user_name from users 
				where id in( 
				SELECT to_id from Requests
				 where from_id='$uid' and request_status='2'
				 and to_id in (
					 select to_id from Requests 
					 where from_id='$profid' and request_status='2') )";
	
		$result= $conn->query($sql);
		return $result;
	}


	public function selectAllUsersWhoareNotFriends($uid){
		$sql ="SELECT user_name,id 
				FROM users 
				WHERE id!='$uid' AND id NOT IN(
				SELECT from_id from Requests Where to_id='$uid'
				UNION
				SELECT to_id from Requests Where from_id='$uid')";
	
		$result = $conn->query($sql);
		return $result;
	}

	public function selectAddedOrRemovedUserIds($uid,$to_id){
		$sql= "SELECT from_id, to_id FROM Requests WHERE from_id='$uid' AND to_id='$to_id'";
		return $result;
	}

	public function insertRequestStatusAddFriend($uid, $to_id){
		$sql ="INSERT INTO Requests (from_id,to_id,request_status) VALUES('$uid','$to_id','1')";
		$result = $conn->query($sql);
		return $result;
	}

	public function insertRequestStatusRemoveFriend($uid, $to_id){
		$sql ="INSERT INTO Requests (from_id,to_id,request_status) VALUES('$uid','$to_id','0')";
		$result = $conn->query($sql);
		return $result;
	}

	public function selectAllUsersWhoSentFriendREquest($uid){
		$sql = "SELECT users.user_name,Requests.from_id
				FROM users
				JOIN Requests 
				ON Requests.from_id = users.id WHERE Requests.to_id = '$uid'";
		$result= $conn->query($sql);
		return $result;
	}

	public function updateRequestStatusAcceptFriend($uid, $from_id){
		$sql = "UPDATE Requests SET request_status='2' WHERE from_id='$from_id' AND to_id='$uid'";
		return $result;
	}

	public function updateRequestStatusDeclineFriend($uid, $from_id){
		$sql = "UPDATE Requests SET request_status='0' WHERE from_id='$from_id' AND to_id='$uid'";
		return $result;
	}
}

?>