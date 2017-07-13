<!-- 
	/*
	 * For creating a new user account.
	 * 
	 * Does validation and creates an account
	 * Inserts the data into the users table in MySQL
	 *
	*/ 
-->

<?php

include 'database/QueryBuilder.php';
include "resources.php";

session_start();

$nameErr = $emailErr = $passwordErr = "";


if (isset($_POST['submit'])) {

	$name= $_POST["username"];
	$emailID= $_POST["emailId"];
	$password= $_POST["password"];
	$flag=0;

	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$nameErr= "Only letters and white space allowed"; 
		$flag=1;
	}

	if (!filter_var($emailID, FILTER_VALIDATE_EMAIL)) {
	  	$emailErr = "Invalid email format"; 
		$flag=1;
	}

	if (strlen($password) >10) {
		$flag =1;
	  	$passwordErr = "Password must be less than 10 charaters"; 
	}


	if($flag ===0) {
		$password= md5($_POST["password"]);
	
		$result= QueryBuilder:: selectEmailID($conn,$uid,$emailID);
		if($result->num_rows==0){
			
			$result= QueryBuilder:: insertNewUserCredentials($conn,$name,$emailID,$password);
			if ($result == True) {
				$result= QueryBuilder::selectUserDetailsForLogin($conn,$emailID,$password);
				$_SESSION['id'] = $result->fetch_assoc()['id'];
				header('Location:newUser.php');

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}


			$conn->close();
		}
	}

}


?>

<html>
	<body>
		<div id="loginBackground"></div>
		<b><p style="font-family: 'Great Vibes', cursive; font-size:100px; color:black" class="text-center"> Photo Sharing Portal </p></b>

		<form action="#" method="post">
		<div class="col-md-4 col-md-offset-4 form-group" style="padding-top: 140px;">
			<div class="panel panel-default">
				<div class="panel-body">
					<label class="form-control-label">User Name:</label>
					<input type="text" name="username" class="form-control"/>	
					<div class="help-block with-errors" style="color:red;"><?php echo $nameErr ?></div>
					<label class="form-control-label">Email ID:</label>
					<input type="text" name="emailId" class="form-control"/> 
					<div class="help-block with-errors" style="color:red;"><?php echo $emailErr ?></div>
					<label class="form-control-label">Password:</label> 
					<input type="password" name = "password" class="form-control"/> 
					<div class="help-block with-errors" style="color:red;"><?php echo $passwordErr ?></div>
					<button class="btn btn-primary" name="submit" type="submit"> Sign Up! </button>
			</div>
			</div>
		</div>
		
		</form>
	</body>
</html>