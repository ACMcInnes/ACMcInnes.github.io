<!DOCTYPE html>
<html>
<head>
<body>
<?php
	include 'myFunctions.php';
	
	$dbcontents = queryArray($conn, "SELECT * FROM shapes");
	$desc = test_input($_GET["add2cart"] ?? '');
	$id = test_input($_GET["id"] ?? '');
	$_SESSION['sessioncart'][] = array($desc , $id);

	loopArray($dbcontents, $_SESSION['sessioncart']);	
?>		
</body>
</head>
</html>