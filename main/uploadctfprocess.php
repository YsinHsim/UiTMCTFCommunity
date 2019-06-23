<?php include('../config/config.php'); //$conn

	session_start();
	$name = $_SESSION['name'];
	$status = ""; //success or not
	$error = "No Error";
	$currentCtfName;

	if(isset($_POST['ctfname'])) {
		$ctfname = mysqli_real_escape_string( $conn, $_POST['ctfname']);
		$ctfplatform = mysqli_real_escape_string( $conn, $_POST['ctfplatform']);
		$ctflanguage = mysqli_real_escape_string( $conn, $_POST['ctflanguage']);
		$ctflevel = mysqli_real_escape_string( $conn, $_POST['ctflevel']);
		$ctfflag = mysqli_real_escape_string( $conn, $_POST['ctfflag']);
		$ctfdesc = mysqli_real_escape_string( $conn, $_POST['ctfdesc']);
		$current_date = date('d-m-Y'); //Server Date
		$uploader = $name;
		///////////////////////////////////////////////////

		if($ctfplatform == "default") {
			echo "<script>alert('Please select your CTF Platform!');window.location='../main/ctfupload.php'</script>";
		}
		else if($ctflanguage == "default") {
			echo "<script>alert('Please select your CTF Language!');window.location='../main/ctfupload.php'</script>";
		}
		else if($ctflevel == "default") {
			echo "<script>alert('Please select your CTF Level!');window.location='../main/ctfupload.php'</script>";
		}
		else {

			$ctfCheck = "SELECT * FROM crackfile WHERE name = '$ctfname'";
			$checkRes = mysqli_query( $conn, $ctfCheck);
			$checkRow = mysqli_num_rows( $checkRes);

			if($checkRes === 0) {
				echo "<script>alert('Please use another name.');window.location='../main/ctfupload.php';</script>";
			}

			$query = "INSERT INTO crackfile(name, platform, language, level, flag, date_uploaded, uploader, description) VALUES ('$ctfname','$ctfplatform','$ctflanguage','$ctflevel','$ctfflag','$current_date','$uploader','$ctfdesc')";

			//If No Error Proceed
			if(mysqli_query( $conn, $query)) {
				$currentCtfName = $ctfname;
			}
			//Else Produce Error
			else {
				$currentCtfName = $ctfname;
				$query2 = "DELETE FROM crackfile WHERE name = ('$currentCtfName')";

				echo "<script>alert('Server Error! Please check your CTF name.');window.location='../main/ctfupload.php';</script>";
			}
			///////////////////////////////////////////////////

			//Getting extension from uploaded file
			$temp = explode(".", $_FILES["ctffile"]["name"]);
			$exts = "." . end($temp);

			$file_name = $currentCtfName; //which mean id of the crackfile table row
			$maxsize = 10000000; //10mb

			$newfilename = $file_name . '.' . end($temp);
			$targetfolder = "../uploaded/ctf/";

			//Check File Size
			if(( $_FILES["ctffile"]["size"] > $maxsize) || ( $_FILES["ctffile"]["size"] == 0)) {
				$error = "File Size Error!";
			}
			//Check File Extension
			if( end($temp) != "zip") {
				$error = "File Type Error!";
			}
			//Check If THere is Error Exist
			if( $error == "No Error") {
				move_uploaded_file($_FILES["ctffile"]["tmp_name"], $targetfolder . $newfilename);
				echo "<script>alert('The CTF Game has been uploaded!');window.location='../main/ctfupload.php';</script>";//
			}
			else {
				if( $error == "File Size Error!") {
					$query2 = "DELETE FROM crackfile WHERE name = ('$currentCtfName')";
					echo "<script>alert('File Size Error!');window.location='../main/ctfupload.php';</script>";

				}
				if( $error == "File Type Error!") {
					$query2 = "DELETE FROM crackfile WHERE name = ('$currentCtfName')";
					echo "<script>alert('File Type Error!');window.location='../main/ctfupload.php';</script>";
				}
			}
		}
	}
?>