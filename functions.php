<?php

include 'database/QueryBuilder.php';

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

function getLikes($pid,$conn){
	$sql = "SELECT sum(like_count) as l from likeTable where pid='$pid'";
	$result= $conn->query($sql);
	
	$likes= $result->fetch_assoc()['l'];
	
	return $likes; 
}


function checkLike($uid, $pid, $conn){

	$sql = "SELECT like_count from likeTable where pid='$pid' and uid='$uid'";
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


function displayPost($user_id, $user_name, $post_name, $uid, $post_id, $image_name, $status, $number_of_likes) {

	echo '<!-- Column 1 (horizontal, vertical, horizontal, vertical) -->
	<div style="box-shadow: 2px 2px 2px 2px #888888;"  class="image fit post card thumbnail">
		<img src="uploads/'.$image_name.'" />
		<div class="caption">
       		<h3><a href="profilePage.php?uid='.urlencode($user_id).'" style="font-weight:bold;">'.$user_name.'</h3></a><hr/>
        	<p>'.$post_name.'</p><br/>
        	<span>'.$number_of_likes.'</span>
	        <a class="like" id="'.$post_id.'"> '.$status.' </a>&nbsp;
	        <a class="comment"> Comment </a>  
	        <a class="see_comments comments_click" style="float:right">view comments </a>
	        <div class="comment_list"></div>
	        <div class="comment_box"></div>
      </div>';
       if($user_id==$uid) {
       echo'
        <button id='.urlencode($post_id).' type="submit" name="edit_post" class="edit_post btn btn-primary"> 
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          Edit
        </button>
        <button id='.urlencode($post_id).' type="submit" name="delete_post" class="delete_post btn btn-danger">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
              Delete
          </button>';
        }
		echo '</div>';
}

function seamlessResponsive($conn,$uid){

	$result= QueryBuilder::selectPostsOfAllUsers($conn, $uid);
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
		echo '
		<div id="main" style="padding-left:20px; padding-right:20px;" >
		<div class="inner">
			<div class="columns">';

		for($i =0; $i< count($json_post); $i++){
			$noOflikes = getLikes($json_id[$i],$conn);
			$status=checkLike($uid, $json_id[$i], $conn);
			
					if($i%4==0){
						echo displayPost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}
					else if($i%4==1){
						echo displayPost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}
					else if($i%4==2){
						echo displayPost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}		
					else if($i%4==3){
						echo displayPost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}

		}
		echo '</div>
		</div>
	</div>';

	}
?>