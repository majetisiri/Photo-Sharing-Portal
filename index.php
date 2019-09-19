<!-- 
	/*
	 * For logging into the app.
	 * 
	 * Does validation and logs into the user profile page if account exists.
	 * If user does not have an account, they can click on Register button to navigate to create login page.
	 *
	*/
-->


<?php 

session_start();

include 'resources.php';
include 'config.php';


$loginErr='';

if (isset($_POST['login'])) {
	$email= $_POST["emailId"];
	$password=md5($_POST["password"]);
	$sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$sql= "SELECT id FROM users WHERE email ='$email' and password='$password'";
		$result = $conn-> query($sql);
		$_SESSION['id'] = $result->fetch_assoc()['id'];
		header('Location:page.php');
	}
	else{
		$loginErr = "Wrong Email or Password!";

	}
}

?>

<style>
 	#background{
		position: fixed;
	    top: 0;
	    z-index: -1000;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background-image: url('https://photo-sharing-portal.s3.us-east-2.amazonaws.com/06d4c2c8-671d-4859-acf0-b3f5145b1167.jpg');
	    background-repeat: no-repeat;
	    background-attachment: fixed;
	    background-size: 100%;
	    opacity: 0.7;
	    filter:alpha(opacity=40);
	}
</style>

<html>
	<body>
		<div id="background"></div>
		<b><p style="font-family: 'Great Vibes', cursive; font-size:100px; color:black" class="text-center"> Photo Sharing Portal </p></b>

		<form action="#" method="post">
		<div class="col-md-4 col-md-offset-4 form-group" style="padding-top: 140px;">
			<div class="panel panel-default">
			<div class="panel-body">
			<label class="form-control-label"> Email ID: </label>
			<input type="text" name="emailId" class="form-control"/> <br>
			<label class="form-control-label"> Password: </label>
			<input type="password" name = "password" class="form-control"/> <br>
			<div class="help-block with-errors" style="color:red;"><?php echo $loginErr ?></div>
			<button type="submit" name ="login" class="btn btn-primary"> Login </button>	
			<a href="createLogin.php">
				<button type="button" class="btn btn-success"> Register </button>
			</a>
			</div>
			</div>
		</div>
		
		</form>
	</body>

</html>
