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

	$row = mysqli_fetch_assoc( $res);

	$ctf = "SELECT * FROM crackfile ORDER BY name DESC";
	$ctfres = mysqli_query( $conn, $ctf);
	$ctfrow = $ctfres -> fetch_assoc();

	//variable
	$showSearchResult = "no";

	if( isset($_POST["operation"])) {
	  		$operation = mysqli_real_escape_string( $conn, $_POST["operation"]);
	  		if( $operation == "searchuser") {
	  			$showSearchResult = "yes";
	  		}
	  		else if( $operation == "viewall") {
	  			$showSearchResult == "no";
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
	  				<li><a href="../main/ctflist.php">CTF List</a></li>
	  				<li><a href="../main/ctfupload.php">CTF Upload</a></li>
	  				<li><a href="../main/flagsubmit.php">Flag Submit</a></li>
	  				<li><a href="../main/scoreboard.php">Scoreboard</a></li>
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
	  					<li class="active">
	  						<a id="username" href="../admin/adminuser.php">User Detail</a>
	  					</li>
	  					<li><a id="admin-username" href=""><?php echo $name; ?></a></li><?php
	  				} ?>
	  				
	  				<li><a type="button" href="#" onclick="logout()">Log out</a></li>
	  			</ul>
	  		</div>
	  	</nav>
	  	<div class="container">
	  		<?php if( $showSearchResult == "no") { ?>

	  			<div class="container-fluid">
		  			<form method="post" action="adminuser.php">
		  				<div class="col-md-4">
		  					<input type="text" name="operation" value="searchuser" hidden>
		  					<input type="text" name="name" class="form-control" placeholder="Enter Username" autocomplete="off">
		  				</div>
		  				<div class="col-md-2">
		  					<input type="submit" class="btn btn-primary" value="Search">
		  				</div>
		  			</form>
		  		</div>
		  		<br><br> <?php
	  		}
	  		else if( $showSearchResult == "yes") { ?>

	  			<div class="container-fluid">
	  				<form method="post" action="adminuser.php">
	  					<input type="text" name="operation" value="viewall" hidden>
	  					<input type="submit" class="btn btn-success" value="View All">
	  				</form>
	  			</div>
	  			<br><br> <?php
	  		} ?>
	  		<?php if( $showSearchResult == "no") {
	  			$user = "SELECT * FROM user ORDER BY username";
	  			$userres = mysqli_query( $conn, $user);
	  			$userrow = mysqli_fetch_assoc( $userres); ?>

	  			<div class="table-responsive">
		  			<table class="table table-dark">
		  				<tr id="tableHeader">
		  					<th>Username</th>
		  					<th>Last CTF Solved</th>
		  					<th>Crack Score</th>
		  					<th>Last Login Date</th>
		  					<th>Last Login Time</th>
		  					<th>Email</th>
		  					<th>User Type</th>
		  					<th>User Status</th>
		  					<th>Change Status</th>
		  				</tr>
		  				<?php
		  					$i = 0;
		  				do {
		  					$i = $i + 1;
		  					$userType = $userrow["user_type"]; ?> 
		  					<tr>
		  						<td>
		  							<?php if( $userType == "Pwner") {
		  								echo $userrow["username"];
		  							} else { ?>
		  								<span id="admin-username"><?php echo $userrow["username"]; ?></span><?php
		  							} ?>
		  							
		  						</td>
		  						<td><?php echo $userrow["last_crack_solved"]; ?></td>
		  						<td><?php echo $userrow["crack_score"]; ?></td>
		  						<td><?php echo $userrow["last_login_date"]; ?></td>
		  						<td><?php echo $userrow["last_login_time"]; ?></td>
		  						<td><?php echo $userrow["email"]; ?></td>
		  						<td><?php echo $userType; ?></td>
		  						<td><?php echo $userrow["user_status"]; ?></td>
		  						<td>
		  							<?php if( $userType == "Pwner") { 
		  								if( $userrow["user_status"] == "Active") { ?>
		  									<a class="btn btn-xs btn-danger" href="../admin/banuser.php?process=ban&name=<?php echo $userrow["username"]; ?>">Ban User</a> <?php
		  								} else if( $userrow["user_status"] == "Not Active") { ?>
		  									<a class="btn btn-xs btn-warning" href="../admin/banuser.php?process=unban&name=<?php echo $userrow["username"]; ?>">Unban User</a> <?php
		  								} ?>
		  							<?php } else {
		  								?><p>Ban Disabled.</p> <?php
		  							} ?>
		  						</td>
		  					</tr> <?php 
		  				} while( ($userrow = mysqli_fetch_assoc( $userres)) && ($i < 20));?>
		  			</table>
		  		</div> <?php
	  		} ?>
	  		<?php if( $showSearchResult == "yes") {
	  			$searchName = mysqli_real_escape_string( $conn, $_POST["name"]);
	  			$user = "SELECT * FROM user WHERE username = '$searchName'";
	  			$userres = mysqli_query( $conn, $user);
	  			$userrow = mysqli_fetch_assoc( $userres); ?>

	  			<div style="width: 38%;" class="col-lg-3 table-responsive">
		  			<h3 id="title">User Detail</h3><br>
		  			<table class="table">
		  				<tr>
		  					<td>Username</td>
		  					<td id="ctfData">: <?php echo $userrow['username']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>Email</td>
		  					<td id="ctfData">: <?php echo $userrow['email']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>User Type</td>
		  					<td id="ctfData">: <?php echo $userrow['user_type']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>User Status</td>
		  					<td id="ctfData">: <?php echo $userrow['user_status']; ?></td>
		  				</tr>
		  			</table>
	  			</div>
	  			<div class="col-lg-2"></div>

	  			<div class="table-responsive col-lg-5">
	  				<br><br>
		  			<table class="table">
		  				<tr>
		  					<td>Last Cracked Solved</td>
		  					<td id="ctfData">: <?php echo $userrow['last_crack_solved']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>CTF Score</td>
		  					<td id="ctfData">: <?php echo $userrow['crack_score']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>Last Login Date</td>
		  					<td id="ctfData">: <?php echo $userrow['last_login_date']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>Last Login Time</td>
		  					<td id="ctfData">: <?php echo $userrow['last_login_time']; ?></td>
		  				</tr>
		  				<tr>
		  					<td>Change Status</td>
		  					<td> <?php
		  						if( $userrow["user_type"] == "Pwner") {
									if( $userrow["user_status"] == "Active") { ?>
										<a class="btn btn-xs btn-danger text-right" href="../admin/banuser.php?process=ban&name=<?php echo $userrow["username"]; ?>">Ban User</a> <?php
									}
									else { ?>
										<a class="btn btn-xs btn-warning text-right" href="../admin/banuser.php?process=unban&name=<?php echo $userrow["username"]; ?>">Unban User</a> <?php
									} 
								}
								else { ?>
									<p id="username">Ban Disable</p><?php
								} ?>
							</td>
						</tr> <?php
						if( $userrow["user_type"] == "Pwner") { ?>
						<tr>
							<td>Change User Type</td>
							<td><a class="btn btn-xs btn-primary text-right" href="../admin/changeusertype.php?username=<?php echo $userrow["username"]; ?>">Change</a>
							</td>
						</tr> <?php
						} ?>
		  			</table>
	  			</div> <?php
	  		} ?>
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
