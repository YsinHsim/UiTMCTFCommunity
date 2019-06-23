<?php include('../config/config.php'); //$conn

	session_start();
	$name = $_SESSION['name'];
	$showSubmit = "No";
	$ctfName;
	$ctfUploader;
	$solved = false;

	$query = "SELECT * FROM user WHERE username = '$name'";
	$res = mysqli_query( $conn, $query);
	$row = mysqli_num_rows($res);

	if($row === 0) {
		//USER TRY TO NAVIGATE TO THIS PAGE WITHOUT PASS THROUGH LOGIN PAGE
		echo "<script>alert('Please login to proceed.');window.location='../user/login.php'</script>";
		die();
	}

	if( isset($_POST['operation'])) {
		$operation = mysqli_real_escape_string( $conn, $_POST['operation']);

		if( $operation == "search") {
			$ctfname = mysqli_real_escape_string( $conn, $_POST['ctfname']);
			$ctfuploader = mysqli_real_escape_string( $conn, $_POST['ctfuploader']);

			$ctf = "SELECT * FROM crackfile WHERE ( name, uploader) = ('$ctfname','$ctfuploader')";
			$ctfres = mysqli_query( $conn, $ctf);
			$ctfrow = mysqli_num_rows( $ctfres);

			if($ctfrow === 1) {
				$showSubmit = "Yes";
				$ctfName = $ctfname;
				$ctfUploader = $ctfuploader;
			}
			else {
				echo "<script> alert('No CTF Game Found. Please try again.');</script";
			}
		}
		if( $operation == "submit") {
			$ctfname = mysqli_real_escape_string( $conn, $_POST['ctfname']);
			$ctfflag = mysqli_real_escape_string( $conn, $_POST['ctfflag']);

			$ctf = "SELECT * FROM crackfile WHERE name = '$ctfname'";
			$ctfres = mysqli_query( $conn, $ctf);
			$ctfrow = $ctfres -> fetch_assoc();

			$user = "SELECT * FROM user WHERE username = '$name'";
					$userres = mysqli_query( $conn, $user);
					$userrow = $userres -> fetch_assoc();

			$flag = $ctfrow['flag'];

			if( $userrow['username'] == $ctfrow['uploader']) {
				echo "<script>alert('Uploader cannot submit flag for their own CTF Game!');</script>";
			}
			//Check if the flag is same...
			else if( $flag != $ctfflag ) {
				echo "<script>alert('The answer is wrong. Try harder!');</script>";
			}
			else {
				$ctflevel = $ctfrow['level'];
				$ctfname = $ctfrow['name'];
				$current_date = date('d-m-Y');
				$addScore = 0;

				$solved = "SELECT * FROM solved WHERE ( ctf_name, ctf_solver) = ('$ctfname','$name')";
				$solvedres = mysqli_query( $conn, $solved);
				$solvedrow = mysqli_num_rows( $solvedres);

				if( $solvedrow === 0) {

					if( $ctflevel == "Very Easy") { 
						$addScore = 125; 
					}
					if( $ctflevel == "Easy") { 
						$addScore = 225; 
					}
					if( $ctflevel == "Average") { 
						$addScore = 325; 
					}
					if( $ctflevel == "Hard") { 
						$addScore = 425; 
					}
					if( $ctflevel == "Very Hard") { 
						$addScore = 525; 
					}

					$original_date = $userrow['last_crack_solved'];
					$currentScore = $userrow['crack_score'];
					$newScore = $currentScore + $addScore;

					$update = "UPDATE user SET crack_score = '$newScore', last_crack_solved = '$current_date' WHERE username = '$name'";
					if( mysqli_query( $conn, $update)) {
						
						$solved2 = "INSERT INTO solved( ctf_name, ctf_solver) VALUES ('$ctfname','$name')";
						if(mysqli_query( $conn, $solved2)){
							echo "<script>alert('Congratulation! You are correct.');</script>";
						}
						else {
							$update2 = "UPDATE user SET crack_score = '$currentScore', last_crack_solved = '$original_date' WHERE username = '$name'";
							$update2res = mysqli_query( $conn, $update2);
							echo "<script>alert('Server Error204! Please try again later.');</script>";
						}
					}
					else {
						echo "<script>alert('Server Error! Please try again later.');</script>";
					}
				}
				else {
					echo "<script>alert('You already solved this problem!');</script>";
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>UiTM CTF Community</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

		<link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">

		<!-- custom css -->
		<link href="../style/style.css" type="text/css" rel="stylesheet">

  	</head>

  	<body>
  		<nav class="navbar navbar-inverse">
  			<div class="container-fluid">
  				<div class="navbar-header">
  					<a id="brand" class="navbar-brand" onclick="welcome()">UiTM CTF Community</a>
  				</div>
	  			<ul class="nav navbar-nav">
	  				<li><a href="ctflist.php">CTF List</a></li>
	  				<li><a href="ctfupload.php">CTF Upload</a></li>
	  				<li class="active"><a href="flagsubmit.php">Flag Submit</a></li>
	  				<li><a href="scoreboard.php">Scoreboard</a></li>
	  			</ul>
	  			<ul class="nav navbar-nav navbar-right">
	  				<?php $row = $res -> fetch_assoc(); 
	  				if($row['user_type'] == "Pwner") 
	  				{ ?>
	  					<li><a id="username" href=""><?php echo $name; ?></a></li><?php
	  				} else if($row['user_type'] == "Admin") 
	  				{ ?>
	  					<li>
	  						<a id="username" href="../admin/adminctf.php">Ctf Detail</a>
	  					</li>
	  					<li>
	  						<a id="username" href="../admin/adminuser.php">User Detail</a>
	  					</li>
	  					<li><a id="admin-username" href=""><?php echo $name; ?></a></li><?php
	  				} ?>
	  				
	  				<li><a type="button" href="#" onclick="logout()">Log out</a></li>
	  			</ul>
	  		</div>
	  	</nav>
	  	<div class="container">
			<div class="col-lg-4">
				<br>
		  		<h2>Search CTF Game</h2>
			  	<p id="warningFont">Search the CTF Game that you want to submit.</p><br>
			  	
				<form method="post" action="flagsubmit.php" autocomplete="off">
					<input type="text" name="operation" value="search" hidden>
			  		<div class="row">
			  			<input class="form-control" name="ctfname" placeholder="Enter CTF Name" required>
			  		</div><br>
			  		<div class="row">
			  			<input class="form-control" name="ctfuploader" placeholder="Enter CTF Uploader" required>
			  		</div><br>
			  		<div class="row text-right">
			  			<input type="submit" class="btn btn-primary" value="Search">
			  		</div>
			  	</form>
			</div>
			<div class="col-lg-2"></div>
			<div class="col-lg-5">
				<?php
				if( $showSubmit == "Yes") { 

						$ctf = "SELECT * FROM crackfile WHERE ( name, uploader) = ('$ctfname','$ctfuploader')";
						$ctfres = mysqli_query( $conn, $ctf);
						$ctfrow = $ctfres -> fetch_assoc();
					?>
					<br>
			  		<h2>Submit CTF Flag</h2>
				  	<p id="warningFont">Sometimes the answer in right in front of you.</p><br>

				  	<table border="0 | 0" width="86%">
				  		<tr>
				  			<th>Name </th>
				  			<td>: <?php echo $ctfrow['name']; ?></td>
				  		</tr>
				  		<tr>
				  			<th>Level </th>
				  			<td>: <?php echo $ctfrow['level']; ?></td>
				  		</tr>
				  		<tr>
				  			<th>Date Uploaded </th>
				  			<td>: <?php echo $ctfrow['date_uploaded']; ?></td>
				  		</tr>
				  	</table><br>
					<form method="post" action="flagsubmit.php" autocomplete="off">
						<input type="text" name="ctfname" value="<?php echo $ctfrow['name']; ?>" hidden>
						<input type="text" name="operation" value="submit" hidden>
				  		<div class="row">
				  			<input name="ctfflag" class="form-control" type="text" placeholder="Enter CTF Flag" required>
				  		</div><br>
				  		<div class="row text-right">
				  			<input type="submit" class="btn btn-success" value="Submit">
				  		</div>
				  	</form>
				  	<?php 

				  	$solved3 = "SELECT * FROM solved WHERE ( ctf_name, ctf_solver) = ('$ctfname','$name')";
					$solvedres3 = mysqli_query( $conn, $solved3);
					$solvedrow3 = mysqli_num_rows( $solvedres3);

					if( $solvedrow3 === 1) {
						?><br><br><h2>Submit Solution?</h2>
						<p id="warningFont">Please submit your solution in .zip file type.</p>
						<form method="post" action="uploadsolprocess.php" enctype="multipart/form-data" autocomplete="off">
							<input type="text" name="ctfname" value="<?php echo $ctfrow['name']; ?>" hidden>
							<div class="row">
								<input name="solname" class="form-control" type="text" placeholder="Enter Solution Name" required>
							</div><br>
							<div class="row">
								<input name="solfile" type="file" class="form-horizontal" required>
							</div><br>
							<div class="row text-right">
								<input type="submit" class="btn btn-primary" value="Submit">
							</div><br>
						</form><?php
					}
				}
				?>
			</div>
	  	</div>
	  	<script>
	  		function logout() {
				if( confirm("Are you sure?")) {
					window.location.href = "../user/logout.php";
				}
			}
		</script>
  	</body>
</html>
