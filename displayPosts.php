<?php


session_start();

include 'config.php';



function displayPosts($conn,$uid) {
	// echo $uid;
	$sql = "SELECT post,id,pid,image_name,user_name 
	FROM postTable 
	JOIN users 
	ON postTable.uid=users.id
	WHERE users.id='$uid'";
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

	for($i =0; $i< count($json_post); $i++){
		echo '
		<div class="col-md-4 col-md-offset-5">
			<table class="table">
				<body>
					<tr>
						<td style="width:30px; overflow:hidden;">
							<a href="profilePage.php?uid='.urlencode($json_uid[$i]).'" style="font-weight:bold;">'.ucwords($json_user_name[$i]).'</a>
						</td>
						<td style="width:420px; text-align:center">
							'.$json_post[$i].'
					 	</td>
					</tr>
				</body>
			</table>
			<table>
				<body>
					<tr>
						<td>
							<div class="col-md-offset-3" style="width:420px; overflow:hidden;">
								<img src=uploads/'.$json_image_name[$i].' height="300px" style="margin-bottom:3em;">
							</div>
						</td>
					</tr>
				</body>
			</table>
		</div>';
	}
}

 ?>
