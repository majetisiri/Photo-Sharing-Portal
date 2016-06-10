<?php

include 'config.php';
include 'search.php';
include 'navHeader.php';


session_start();



$uid = $_SESSION['id'];
	
function displayPosts_all($conn,$uid) {

	$sql = "SELECT post,id,pid,image_name,user_name 
	FROM postTable 
	JOIN users 
	ON postTable.uid=users.id";
	$result = $conn->query($sql);

	$json_post= array();
	$json_id = array();
	$json_image_name = array();
	$json_user_name = array();
	$json_uid = array();

	while($row= $result->fetch_assoc()){
		array_push($json_post,$row['post']);
		array_push($json_id, $row['pid']);
		array_push($json_image_name, $row['image_name']);
		array_push($json_user_name, $row['user_name']);
		array_push($json_uid, $row['id']);
	}

 	function getComments($pid,$conn){
 		$sql = "SELECT comment from commentTable where pid='$pid'";
 		$result= $conn->query($sql);
 		$json_comment=array();
 		while($row= $result->fetch_assoc()){
 			array_push($json_comment,$row['comment']);
 		}
 		return $json_comment; 
 		// print_r($json_comment);
 	}

 	function getLikes($pid,$conn){
 		$sql = "SELECT sum(like_count) as l from likeTable where pid='$pid'";
 		$result= $conn->query($sql);
 		
 		$likes= $result->fetch_assoc()['l'];
 		
 		return $likes; 
 		print $likes;
 	}


 	function checkLike($pid,$conn){
	 	$sql = "SELECT like_count from likeTable where pid='$pid'";
	 	$result= $conn->query($sql);
	 		
	 	$like_status= $result->fetch_assoc()['like_count'];
	 	if($like_status == 1){
	 		$status= 'Unlike';
	 	}
	  else{
	  		$status= 'Like';
	 	 }
	 	 return $status; 
 	}

	for($i =0; $i< count($json_post); $i++){
		$commentArray = getComments($json_id[$i],$conn);
		$NoOflikes = getLikes($json_id[$i],$conn);
		$status=checkLike($json_id[$i],$conn);

		echo '
		<div class="col-md-5 col-md-offset-3 row">
			<table class="table">
				<body>
					<tr>
						<td style="width:30px; overflow:hidden;">
							<a href="profilePage.php?uid='.urlencode($json_uid[$i]).'" style="font-weight:bold;">'.ucwords($json_user_name[$i]).'</a>
						</td>
						<td style="width:420px; text-align:center">
					 		'.$json_post[$i].'
					 	</td>
					 	<td>
							';
							if($json_uid[$i]==$uid){
								echo '
									<a href=edit.php?edit_id='.urlencode($json_id[$i]).'>
										<button type="submit" name="edit_post" class="btn btn-primary" style="margin-left:100px;"> Edit</button>
									</a>
									<a href=page.php?delete_id='.urlencode($json_id[$i]).'> 
										<button type="submit" name="delete_post" class="btn btn-danger"> Delete</button>
									</a>';
								}
							echo '
						</td>
					</tr>
				</body>
			</table>
			<table class="parentTable">
				<tr>
					<td>
							<div class="col-md-offset-3" style="width:420px; overflow:hidden;">
								<img src=uploads/'.$json_image_name[$i].' height="300px">
								<a class="NoOflikes">'.$NoOflikes.'</a>
								<a class="like" id="'.$json_id[$i].'" > '.$status.'</a>
								<a  class="comment" style="padding-left:15px">Comment</a>
							</div>
							<div class="comment_box"></div>
					</td>
				</tr>
			</table>';

		echo '
			<table>
				<tr>
					<div><i>Comments</i></div>
					<ul class="comment_list">';

					if(count($commentArray) ==0){
						echo '<p class="help-block with-errors no_comments" style="color:red;">No Comments</p>';
					}
					else{

						$commentArray_len = count($commentArray);

						$count = ($commentArray_len >= 4) ? 4: count($commentArray); 

						for($j=0;$j<$count;$j++) {
							echo '<li>'. $commentArray[$j].'</li>';
						}

						for($j=$count; $j<count($commentArray); $j++){
							echo '<li class="comments_hidden" style="display:none;">'. $commentArray[$j].'</li>';
							
						}
						echo '</ul>';
						if(count($commentArray) > 4) {
							echo '<a class="see_more">See more !</a>';
						}

			 		}
									
				echo '
				</tr>
			</table>
		</div>';
	}
}

if(isset($_POST["logout"])){
	session_destroy();
	header('Location:loginForm.php');
	exit();
}

$postErr = "";
if(isset($_POST["post_data"]) && isset($_FILES['fileToUpload'])){
	$file_new_name = fileupload();
	//echo $file_new_name;
	$post =$_POST["post_data"];
	if($post!= NULL && $file_new_name!= NULL){
		$uid= $_SESSION['id'];
		
		$sql ="INSERT INTO postTable (post,image_name,uid) VALUES ('$post','$file_new_name','$uid')";
		if ($conn->query($sql) === FALSE) {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		$postErr = "No post";
	}
	
}
elseif(isset($_GET['delete_id'])) {
	$delete_id = $_GET['delete_id'];
	//print $delete_id;
	$sql = "DELETE from postTable where pid='$delete_id'";
	$result = $conn->query($sql);
	if(!$result) {
		echo "Error: " . $sql . "<br>" . $conn->error;	
	}
}

function fileupload(){
	$file=$_FILES['fileToUpload'];
	$file_name=$file["name"];
	$file_size=$file["size"];
	$file_tmpname=$file["tmp_name"];
	$file_error=$file["error"];
	
	$file_ext= explode('.',$file_name);
	$file_ext= strtolower(end($file_ext));

	$allowed_exts=array('jpg','png','jpeg');

	if(in_array($file_ext,$allowed_exts)){
		if($file_error ===0){
			if($file_size<= 2097512){
				$file_new_name = uniqid('',true).'.'.$file_ext;
				$file_destination ='uploads/'.$file_new_name;
				if(move_uploaded_file($file_tmpname,$file_destination)){
					return $file_new_name;
				}	
			}
		}
	}
}	

// echo $_SESSION['id'];



echo '
<div class="col-md-5 col-md-offset-3 row">
<form action="#" method="post" enctype="multipart/form-data">
	<textarea class="form-control" rows="5" cols="90" name="post_data" placeholder="write your post here"></textarea> 
	<div class="help-block with-errors" style="color:red;">'.$postErr .'</div>
	<div class="row">
		<div class="col-md-4"> 
			<input type="file" name="fileToUpload" id="fileToUpload"> 
		</div>
		<div class="col-md-3 pull-right">
			 <button name="submit" type="submit" class="btn btn-primary pull-right"> Post  </button>
		</div>
	</div>
</form>
</div>

<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
<script type="text/javascript" src="siri.js"> </script>
';

displayPosts_all($conn,$uid);

?>
