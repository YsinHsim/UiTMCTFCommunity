<?php
include ('../config/config.php'); //$conn

if(isset($_GET["ctfsolution"])) {
	$ctfsolution = mysqli_real_escape_string( $conn, $_GET["ctfsolution"]);

	$del = "DELETE from solution WHERE sol_name = '$ctfsolution'";

	if( mysqli_query( $conn, $del) === true) {
		echo "<script>alert('CTF Solution has been deleted!');window.location='../admin/adminctf.php';</script>";
	}
	else {
		echo "<script>alert('Delete failed! Please try again.');window.location='../admin/adminctf.php';</script>";
	}
}
else {
	echo "<script>alert('Server Error! Please try again.');window.location='../admin/adminctf.php';</script>";
}
?>