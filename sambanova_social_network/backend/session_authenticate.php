

<?php
	
//set session
if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
//$uid=strip_tags($_GET['uid']);
		header("location: index.php");
		exit();
	}


?>