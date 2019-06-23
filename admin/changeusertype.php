<?php
include ('../config/config.php'); //$conn

if(isset($_GET["username"])) {
	$username = mysqli_real_escape_string( $conn, $_GET["username"]);

	$del = "UPDATE user SET user_type = 'Admin' WHERE username = '$username'";

	if( mysqli_query( $conn, $del) === true) {
		echo "<script>alert('User Type has been changed!');window.location='../admin/adminuser.php';</script>";
	}
	else {
		echo "<script>alert('Operation failed! Please try again.');window.location='../admin/adminuser.php';</script>";
	}
}
else {
	echo "<script>alert('Server Error! Please try again.');window.location='../admin/adminuser.php';</script>";
}
?>