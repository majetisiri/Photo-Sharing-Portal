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


include "config.php";
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
	
		$sql = "SELECT email FROM users WHERE email='$emailID'";
		$result= $conn->query($sql);
		if($result->num_rows==0){
			$sql = "INSERT INTO users (user_name, email, password) VALUES ('$name', '$emailID',  '$password')";

			if ($conn->query($sql) === TRUE) {
			
			    echo "New record created successfully";

				$sql= "SELECT id FROM users WHERE email ='$emailID' and password='$password'";
				$result = $conn-> query($sql);
				$_SESSION['id'] = $result->fetch_assoc()['id'];
				header('Location:page.php');

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}


			$conn->close();
		}
	}

}


?>

<style>
 	#loginBackground{
		position: fixed;
	    top: 0;
	    z-index: -1000;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background-image: url('http://belindashi.com/wp-content/uploads/2013/12/G+-Collage-21_2x11_9-15.jpg');
	    background-repeat: no-repeat;
	    background-attachment: fixed;
	    background-size: 100%;
	    opacity: 0.7;
	    filter:alpha(opacity=40);
	}
</style>

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