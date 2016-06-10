 <?php
$servername = "localhost";
$username = "root";
$password = "siri";
$dbname = "siri_db";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

$username =$_POST["username"];
$emailID = $_POST["emailId"];
$password = $_POST["password"];

$error_flag = 0;

if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
		$_SESSION["nameErr"] = "Only letters and white space allowed"; 
		$error_flag = 1;
}

if (!filter_var($emailID, FILTER_VALIDATE_EMAIL)) {
  $_SESSION["emailErr"] = "Invalid email format"; 
  $error_flag = 1;
}



if (strlen($password) >10) {
  $_SESSION["passwordErr"] = "Password must be less than 10 charaters"; 
  $error_flag = 1;
}



if(isset($error_flag)){
	header('location:createLogin.php');
}
else{
	$sql = "INSERT INTO users (user_name, email, password) VALUES ('$username', '$emailID',  '$password')";

	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

}

?>
