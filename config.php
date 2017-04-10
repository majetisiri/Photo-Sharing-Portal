<!-- 
	/*
	 * For creating the connection with the MySQL database.
	 *
	*/
 -->
 
<?php 

$servername="localhost";
$username="root";
$password="siri";
$dbname="photo_sharing";

	
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

