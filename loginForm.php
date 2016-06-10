<?php 

session_start();

include 'config.php';

if (isset($_POST['login'])) {
	$email= $_POST["emailId"];
	$password=$_POST["password"];
	
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
//e page lo validation 
//if(validation success) {
//	session['user_id']; ....
//	header_location marchu ....
//}

?>
<html>
	<body>
	<form action="#" method="post">

	<div class="col-md-4 col-md-offset-4 form-group row">
		<label class="form-control-label"> Email ID: </label>
		<input type="text" name="emailId" class="form-control"/> <br>
		<label class="form-control-label"> Password: </label>
		<input type="password" name = "password" class="form-control"/> <br>
		<div class="help-block with-errors" style="color:red;"><?php echo $loginErr ?></div>
		<button type="submit" name ="login" class="btn btn-primary"> Login </button>	
		<a href="createLogin.php">
			<button type="button" class="btn btn-primary"> Register </button>
		</a>
	
	</div>
	
	</form>

	</body>

</html>