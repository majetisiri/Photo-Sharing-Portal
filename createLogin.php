<?php


include "config.php";


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

		$sql = "SELECT email FROM users WHERE email='$emailID'";
		$result= $conn->query($sql);
		if($result->num_rows==0){
			$sql = "INSERT INTO users (user_name, email, password) VALUES ('$name', '$emailID',  '$password')";

			if ($conn->query($sql) === TRUE) {
			
			    echo "New record created successfully";
			    header('Location:details.php');
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
		<div class="col-md-4 col-md-offset-4">
		<form  action="#" method="post">
			<label class="form-control-label">User Name:</label>
			<input type="text" name="username" class="form-control"/>	
			<div class="help-block with-errors" style="color:red;"><?php echo $nameErr ?></div>
			<label class="form-control-label">Email ID:</label>
			<input type="text" name="emailId" class="form-control"/> 
			<div class="help-block with-errors" style="color:red;"><?php echo $emailErr ?></div>
			<label class="form-control-label">Password:</label> 
			<input type="password" name = "password" class="form-control"/> 
			<div class="help-block with-errors" style="color:red;"><?php echo $passwordErr ?></div>
		<button class="btn btn-primary" name="submit" type="submit"> SIgn Up! </button>
		</form>
		</div>
	</body>
</html>