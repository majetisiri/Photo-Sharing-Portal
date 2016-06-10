<?php 
echo '<link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="./js/jquery.js"></script>
';

$servername="localhost";
$username="root";
$password="siri";
$dbname="siri_db";

	
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

