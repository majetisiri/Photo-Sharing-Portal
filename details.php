<?php

	
include "config.php";

?>


<html>
	<body>
		<div class="col-md-4 col-md-offset-4">
		<form  action="profilePage.php" method="post">
			<label class="form-control-label">First Name:</label>
			<input type="text" name="firstname" class="form-control"/>	
			<label class="form-control-label">Last Name: :</label>
			<input type="text" name="lastname" class="form-control"/> 
			<label class="form-control-label">Place: </label> 
			<input type="text" name = "place" class="form-control"/> 
			<label class="form-control-label">Date of Birth: </label> 
			<input type="text" name = "dateofbirth" class="form-control"/>
			<label class="form-control-label">About Me: </label> 
			<textarea name = "aboutme" class="form-control"/></textarea> 
		<button class="btn btn-primary" name="submit" type="submit"> Submit </button>
		</form>
		</div>
	</body>
</html>