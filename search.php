<?php

include 'config.php';
include 'displayPosts.php';

$search_str="";
if(isset($_POST["search"])){
	$search_str =$_POST["search_data"];
	// echo $search_str;
	search($search_str,$conn);

}

function search($search_str,$conn){
	// print $search_str;
	$sql="SELECT user_name,id from users where user_name like '$search_str%'";
	$result = $conn->query($sql);
	
	while($row=$result->fetch_assoc()){
		$id = $row['id'];
	}	
	displayPosts($conn,$id);
}

?>
