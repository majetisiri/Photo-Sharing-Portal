<?php

include 'database/QueryBuilder.php';
include 'resources.php';

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

function profilePicUpload(){
	$file=$_FILES['profilePicUpload'];
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
				$file_destination ='profile_pics/'.$file_new_name;
				if(move_uploaded_file($file_tmpname,$file_destination)){
					return $file_new_name;
				}	
			}
		}
	}
}	

function postModal($postErr){
	echo '<!-- Modal -->
	  <div class="modal fade" id="postModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Attach Image, write description & POST!!</h4>
	        </div>
	        <div class="modal-body">
	        <form action="#" method="post" enctype="multipart/form-data">
				<textarea class="form-control" rows="5" cols="90" name="post_data" placeholder="write your post here"></textarea> 
				<div class="help-block with-errors" style="color:red;">'.$postErr .'</div>
				<div class="row">
					<div class="col-md-4"> 
						<input type="file" name="fileToUpload" id="fileToUpload"> 
					</div>
					<div class="col-md-3 pull-right">
						 <button name="submit" type="submit" class="btn btn-primary pull-right"> 
						 	<i class="fa fa-pencil" aria-hidden="true"></i>
						 	Post  
						 </button>
					</div>
				</div>
			</form>
	        </div>
	      </div>
	      
	    </div>
	  </div>';
	 }

function commentsModal($conn,$post_id){

	// $result = QueryBuilder::getUserDetails($conn,$post_id);
	// $row= $result->fetch_assoc();
	echo '<!-- Modal -->
	  <div class="modal fade" id="commentsModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Comments</h4>
	        </div>
	        <div class="modal-body">
	        	<blockquote>
				  <p>Wowww</p>
				    <div>
				      <img src="https://www.w3schools.com/css/trolltunga.jpg" style="height:80px; width:80px; padding-right:5px;" class="w3-border w3-padding pull-left" alt="Norway">
				    	<p style="font-size:15px;">Siri</p>
				    	<footer>17th august</footer>
					</div>
				  </blockquote>
				<blockquote class="blockquote-reverse">
				  <p>Nice dish. looking colorful.</p>
				    <div>
				      <img src="https://public-media.smithsonianmag.com/filer/89/47/8947cd5c-ac01-4c0e-891a-505517cc0663/istock-540753808.jpg" style="height:80px; width:80px; padding-left:5px;" class="w3-border w3-padding pull-right" alt="Norway">
				    	<p style="font-size:15px;">Vamshi Kolanu</p>
				    	<footer>17th august</footer>
					</div>
				  </blockquote>
	        </div>
	      </div>
	      
	    </div>
	  </div>';
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


function userDetails($conn,$uid){

	$result= QueryBuilder::getUserDetails($conn,$uid);
	if($result->num_rows==1){
		$row= $result->fetch_assoc();
		return array($row['first_name'],$row['last_name'],$row['age'],$row['sex'],$row['phone'],$row['birthday'],$row['profile_pic']);
	}
	
}

function getCommentsandDetails($conn,$pid){
	$result= QueryBuilder::getCommentDetails($conn,$pid);
	if($result->num_rows>0){
		$row= $result->fetch_assoc();
		return array($row['first_name'],$row['last_name'],$row['comment'],$row['created_at']);
	}
}

function displayPost($user_id, $user_name, $post_name, $uid, $post_id, $image_name, $status, $number_of_likes) {

	echo '<!-- Column 1 (horizontal, vertical, horizontal, vertical) -->
	<div style="box-shadow: 2px 2px 2px 2px #888888;"  class="image fit post card thumbnail">
		<img src="uploads/'.$image_name.'" />
		';
       if($user_id==$uid) {
       echo'
       <div class="caption">
       		<h3><style="font-weight:bold;">'.$user_name.'</h3><hr/>
        	<p>'.$post_name.'</p><br/>
        	<span>'.$number_of_likes.'</span>
	        <a class="like" id="'.$post_id.'"> '.$status.' </a>&nbsp;
	        <a class="comment"> <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>  
	        <a class="see_comments comments_click" style="float:right" data-toggle="modal" data-target="#commentsModal">View More </a>
	        <div class="comment_box"></div>
      </div>
        <button id='.urlencode($post_id).' type="submit" name="edit_post" class="edit_post btn btn-primary"> 
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          Edit
        </button>
        <button id='.urlencode($post_id).' type="submit" name="delete_post" class="delete_post btn btn-danger">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
              Delete
          </button>';
        }else{
        	 echo'
       <div class="caption">
       		<h3><a href="profilePage.php?uid='.urlencode($user_id).'" style="font-weight:bold;">'.$user_name.'</h3></a><hr/>
        	<p>'.$post_name.'</p><br/>
        	<span>'.$number_of_likes.'</span>
	        <a class="like" id="'.$post_id.'"> '.$status.' </a>&nbsp;
	        <a class="comment"> <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>  
	        <a class="see_comments comments_click" style="float:right" data-toggle="modal" data-target="#commentsModal">View More </a>
	        <div class="comment_box"></div>
      </div>';
        }
		echo '</div>';	
		
}

function profilePagePost($user_id, $user_name, $post_name, $uid, $post_id, $image_name, $status, $number_of_likes) {

	echo '<!-- Column 1 (horizontal, vertical, horizontal, vertical) -->
	<div style="box-shadow: 2px 2px 2px 2px #888888;"  class="image fit post card thumbnail">
		<img src="uploads/'.$image_name.'" />
       <div class="caption">
       		<h3><style="font-weight:bold;">'.$user_name.'</h3><hr/>
        	<p>'.$post_name.'</p><br/>
        	<span>'.$number_of_likes.'</span>
	        <a class="like" id="'.$post_id.'"> '.$status.' </a>&nbsp;
	        <a class="comment"> <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>  
	        <a class="see_comments comments_click" style="float:right" data-toggle="modal" data-target="#commentsModal">View More </a>
	        <div class="comment_box"></div>
      </div>';
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

	function myPageSeamlessResponsive($conn,$uid){

	$result= QueryBuilder::selectAllPostsOfUser($conn, $uid);
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
	
	function profilePageSeamlessResponsive($conn,$uid){

	$result= QueryBuilder::selectAllPostsOfUser($conn, $uid);
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
						echo profilePagePost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}
					else if($i%4==1){
						echo profilePagePost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}
					else if($i%4==2){
						echo profilePagePost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}		
					else if($i%4==3){
						echo profilePagePost($json_uid[$i], $json_user_name[$i], $json_post[$i], $uid, $json_id[$i], $json_image_name[$i], $status, $noOflikes );
					}

		}
		echo '</div>
		</div>
	</div>';

	}
?>

