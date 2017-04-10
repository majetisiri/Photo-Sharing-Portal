<!--
	 /*
	 * For logging out and closing the session.
	*/ 
-->

<?php
	session_unset(); 
	session_destroy();
	header('Location:index.php');
?>
