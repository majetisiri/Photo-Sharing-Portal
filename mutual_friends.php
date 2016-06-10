<?php

function mutualFriends($uid,$profid){
	include 'config.php';
	// echo $uid, $profid;
	$sql="SELECT user_name from users 
	where id in( 
		SELECT to_id from Requests
		 where from_id='$uid' and request_status='2'
		 and to_id in (
			 select to_id from Requests 
			 where from_id='$profid' and request_status='2') )";
	// echo $sql;
	$result= $conn->query($sql);

	$json_mutualfrds=array();

	while($row= $result->fetch_assoc()){
		array_push($json_mutualfrds,$row['user_name']);
	}

	//return $json_mutualfrds;
	$count = 0;
	for($j=0; $j<count($json_mutualfrds); $j++){
		$count = $count+1;
		if($count <6){
			echo '
			<div style="font-size:12px" class="row col-md-5 col-md-offset-3 
			">'
			.$json_mutualfrds[$j].',</div>';
		}
		else if($count == count($json_mutualfrds)){
			$remain_count = $count-5;
			echo $remain_count.'more mutual friends';
		}
	}
	// print_r($result);
}
	
?>
