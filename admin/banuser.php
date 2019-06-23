<?php

include ('../config/config.php'); //$conn

if(isset($_GET["process"])) {
	$process = $_GET["process"];
	$name = $_GET["name"];

	if( $process == "ban") {
		$newStatus = "Not Active";
		$sql = "UPDATE user SET user_status = '".$newStatus."' WHERE username = '$name'";

		if( mysqli_query( $conn, $sql)) {
			echo "<script>alert('User has been banned.');window.location='../admin/adminuser.php';</script>";
		}
		else {
			echo "<script>alert('Server Error!');window.location='../admin/adminuser.php';</script>";
		}
	}
	else if( $process == "unban") {
		$newStatus = "Active";
		$sql = "UPDATE user SET user_status = '".$newStatus."' WHERE username = '$name'";

		if( mysqli_query( $conn, $sql)) {
			echo "<script>alert('User has been unbanned.');window.location='../admin/adminuser.php';</script>";
		}
		else {
			echo "<script>alert('Server Error!');window.location='../admin/adminuser.php';</script>";
		}
	}
}

?>

