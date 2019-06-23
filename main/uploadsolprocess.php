<?php include('../config/config.php'); //$conn

	session_start();
	$name = $_SESSION['name'];
	$status = ""; //success or not
	$error = "No Error";
	$currentSolName;

	if(isset($_POST['solname'])) {
		$sol_name = mysqli_real_escape_string( $conn, $_POST['solname']);
		$ctf_name = mysqli_real_escape_string( $conn, $_POST['ctfname']);
		$current_date = date('d-m-Y'); //Server Date
		$uploader = $name;
		///////////////////////////////////////////////////

			$query = "INSERT INTO solution(sol_name, sol_ctf, sol_uploader, date_uploaded) VALUES ('$sol_name', '$ctf_name', '$uploader', '$current_date')";

			//If No Error Proceed
			if(mysqli_query( $conn, $query)) {
				$currentSolName = $sol_name;
			}
			//Else Produce Error
			else {
				$query2 = "DELETE FROM solution WHERE sol_name = ('$sol_name')";

				echo "<script>alert('Server Error! Please try different name.');window.location='../main/flagsubmit.php';</script>";
			}
			///////////////////////////////////////////////////

			//Getting extension from uploaded file
			$temp = explode(".", $_FILES["solfile"]["name"]);
			$exts = "." . end($temp);

			$file_name = $currentSolName; //which mean id of the crackfile table row
			$maxsize = 10000000; //10mb

			$newfilename = $file_name . '.' . end($temp);
			$targetfolder = "../uploaded/solution/";

			//Check File Size
			if(( $_FILES["solfile"]["size"] > $maxsize) || ( $_FILES["solfile"]["size"] == 0)) {
				$error = "File Size Error!";
			}
			//Check File Extension
			if( end($temp) != "zip") {
				$error = "File Type Error!";
			}
			//Check If THere is Error Exist
			if( $error == "No Error") {
				move_uploaded_file($_FILES["solfile"]["tmp_name"], $targetfolder . $newfilename);
				echo "<script>alert('The CTF Solution has been uploaded!');window.location='../main/flagsubmit.php';</script>";//
			}
			else {
				if( $error == "File Size Error!") {
					$query2 = "DELETE * FROM solution WHERE sol_name = ('$sol_name')";
					echo "<script>alert('File Size Error!');</script>";//window.location='../main/flagsubmit.php';

				}
				if( $error == "File Type Error!") {
					$query2 = "DELETE * FROM solution WHERE sol_name = ('$sol_name')";
					echo "<script>alert('File Type Error!');</script>";//window.location='../main/flagsubmit.php';
				}
			}
	}
?>
<html>
<body>
<?php echo $_FILES["solfile"]["name"]; ?><br>

</body>
</html>