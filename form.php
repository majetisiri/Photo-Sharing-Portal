<?php

session_start();

if(isset($_SESSION)){
	print $_SESSION['username'];
	print $_SESSION['email'];
}

?>

<html>
	<body>
		<form action="form_validate.php" method="post">
			<p>User Name:</p><input type="text" name="username"/> <br>
			<p> Email_id: </p> <input type="text" name = "email"/><br> 
			<p> Password </p> <input type="password" name="password" /><br>

			<button name='submit' type="submit"> Submit </button>
		</form>
	</body>
</html>