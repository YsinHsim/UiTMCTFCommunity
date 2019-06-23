<?php include('../config/config.php'); //$conn

	session_start();
	$name = $_SESSION['name'];
	$status = null;

	$query = "SELECT * FROM user WHERE username = '$name'";
	$res = mysqli_query( $conn, $query);
	$row = mysqli_num_rows($res);

	if($row === 0) {
		//USER TRY TO NAVIGATE TO THIS PAGE WITHOUT PASS THROUGH LOGIN PAGE
		echo "<script>alert('Please login to proceed.');window.location='../user/login.php'</script>";
		die();
	}
	$row = $res -> fetch_assoc();
	if($row['user_status'] == "Not Active"){
		echo "<script>alert('You had been banned by administrator.');window.location='../user/login.php'</script>";
	}

	$ctf = "SELECT * FROM crackfile ORDER BY name DESC";
	$ctfres = mysqli_query( $conn, $ctf);
	$ctfrow = mysqli_fetch_assoc( $ctfres);
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
	  				<li class="active"><a href="ctflist.php">CTF List</a></li>
	  				<li><a href="ctfupload.php">CTF Upload</a></li>
	  				<li><a href="flagsubmit.php">Flag Submit</a></li>
	  				<li><a href="scoreboard.php">Scoreboard</a></li>
	  			</ul>
	  			<ul class="nav navbar-nav navbar-right">
	  				<?php if($row['user_type'] == "Pwner") 
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
	  		<h3 id="title">Latest CTF Game</h3>
	  		<div class="table-responsive">
	  			<table class="table table-dark">
	  				<tr id="tableHeader">
	  					<th>Name</th>
	  					<th>Uploader</th>
	  					<th>Language</th>
	  					<th>Level</th>
	  					<th>Platform</th>
	  					<th>Date</th>
	  					<th>Link</th>
	  				</tr>
	  				<?php
	  					$i = 0;
	  				do {
	  					$i = $i + 1;?> 
	  					<tr>
	  						<td><?php echo $ctfrow["name"]; ?></td>
	  						<td><?php echo $ctfrow["uploader"]; ?></td>
	  						<td><?php echo $ctfrow["language"]; ?></td>
	  						<td><?php echo $ctfrow["level"]; ?></td>
	  						<td><?php echo $ctfrow["platform"]; ?></td>
	  						<td><?php echo $ctfrow["date_uploaded"]; ?></td>
	  						<td><a class="btn btn-xs btn-primary" href="../main/ctfdetail.php?ctfname=<?php echo $ctfrow["name"]; ?>">Pwn Me</a>
	  						</td>
	  					</tr>

	  				<?php } while( ($ctfrow = $ctfres -> fetch_assoc()) && ($i < 20));?>
	  			</table>
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
