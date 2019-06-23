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

	$query2 = "SELECT * FROM user ORDER BY crack_score DESC";
	$res2 = mysqli_query( $conn, $query2);
	$row2 = $res2 -> fetch_assoc();

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
	  				<li><a href="flagsubmit.php">Flag Submit</a></li>
	  				<li class="active"><a href="scoreboard.php">Scoreboard</a></li>
	  			</ul>
	  			<ul class="nav navbar-nav navbar-right">
	  				<?php
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
	  		<div class="col-lg-6">
	  			<h3 id="title">Scoreboard</h3>
			  	<div class="table-responsive">
			  		<table class="table table-dark">
			  			<tr id="tableHeader">
			  				<th>Username</th>
			  				<th>Score</th>
			  				<th>Last CTF Solved</th>
			  			</tr>
			  			<?php $i = 0;
			  			do { ?>
			  				<tr>
			  					<td><?php echo $row2['username']; ?></td>
			  					<td><?php echo $row2['crack_score']; ?></td>
			  					<td><?php echo $row2['last_crack_solved']; ?></td>
			  				</tr> <?php $i = $i + 1;
			  			} while( ($row2 = $res2 -> fetch_assoc()) && ($i < 30)); ?>
			  		</table>
			  	</div>
			</div>
			<div class="col-lg-2"></div>
			<div class="col-lg-4">
				<div class="row">
					<h3 id="title">Detail : <?php echo $name; ?></h3>
				</div>
				<div class="row">
					<h5>Email : <span id="username"><?php echo $row['email']; ?></span></h5>
				</div>
				<div class="row">
					<h5>Score : <span id="username"><?php echo $row['crack_score']; ?></span></h5>
				</div>
				<div class="row">
					<h5>Last CTF Solved : <span id="username"><?php echo $row['last_crack_solved']; ?></span></h5>
				</div>
				<div class="row">
					<h5>Last Login : <span id="username"><?php echo $row['last_login_date']; ?></span></h5>
				</div>
				<br><br><br>
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