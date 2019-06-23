<?php
include ('../config/config.php'); //$conn

if(isset($_GET["ctfname"])) {
	$ctfname = mysqli_real_escape_string( $conn, $_GET["ctfname"]);

	$del = "DELETE from crackfile WHERE name = '$ctfname'";

	if( mysqli_query( $conn, $del) === true) {
		echo "<script>alert('CTF Game has been deleted!');window.location='../admin/adminctf.php';</script>";
	}
	else {
		echo "<script>alert('Delete failed! Please try again.');window.location='../admin/adminctf.php';</script>";
	}
}
else {
	echo "<script>alert('Server Error! Please try again.');window.location='../admin/adminctf.php';</script>";
}
?>