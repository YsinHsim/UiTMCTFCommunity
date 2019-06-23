<?php include('../config/config.php');

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

  	<body onload="startConsole()">
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
	  					<li class="active">
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

	  	<?php $ctfname = mysqli_real_escape_string( $conn, $_GET["ctf"]);

	  			$ctf2 = "SELECT * FROM crackfile WHERE name = '$ctfname'";
	  			$ctfres2 = mysqli_query( $conn, $ctf2);
	  			$ctfrow2 = mysqli_num_rows( $ctfres2);

	  			?><div class="container-fluid" id="searchContent">

	  				<?php if( $ctfrow2 === 1) { 
	  					$ctf3 ="SELECT * FROM crackfile WHERE name = '$ctfname'";
	  					$ctfres3 = mysqli_query( $conn, $ctf3);
	  					$ctfrow3 = $ctfres3 -> fetch_assoc(); ?>
	  					
	  					<div id="searchedCtf" style="width: 38%;" class="col-lg-3 table-responsive">
				  			<h3 id="title">CTF Game Detail</h3><br>
				  			<table class="table">
				  				<tr>
				  					<td>Name</td>
				  					<td id="ctfData">: <?php echo $ctfrow3['name']; ?></td>
				  				</tr>
				  				<tr>
				  					<td>Uploader</td>
				  					<td id="ctfData">: <?php echo $ctfrow3['uploader']; ?></td>
				  				</tr>
				  				<tr>
				  					<td>Date Uploaded</td>
				  					<td id="ctfData">: <?php echo $ctfrow3['date_uploaded']; ?></td>
				  				</tr>
				  				<tr>
				  					<td>Platform</td>
				  					<td id="ctfData">: <?php echo $ctfrow3['platform']; ?></td>
				  				</tr>
				  				<tr>
				  					<td>Language</td>
				  					<td id="ctfData">: <?php echo $ctfrow3['language']; ?></td>
				  				</tr>
				  				<tr>
				  					<td>Level</td>
				  					<td id="ctfData">: <?php echo $ctfrow3['level']; ?></td>
				  				</tr>
				  				<tr>
				  					<td></td>
				  					<td>
				  						<div class="text-right">
				  							<a class="btn btn-sm btn-danger" href="../admin/deletectf.php?ctfname=<?php echo $ctfrow3['name']; ?>">Delete</a> 
				  							<a type="button" class="btn btn-sm btn-primary" href="<?php echo $path; ?>">Download</a>
				  						</div>
				  					</td>
				  				</tr>
				  			</table>
	  					</div>
	  					<div class="col-lg-2"></div>
				  		<input type="text" id="getDescription" value="<?php echo $ctfrow3['description']; ?>" hidden>
				  		<div class="col-lg-5"  onload="startConsole()">
				  			<h3 id="title">CTF Game Description</h3><br>
				  			<span id="console-effect"></span><br><br>
				  			<div class="container-fluid">
				  				<?php
				  					$sol = "SELECT * FROM solution WHERE sol_ctf = '$ctfname'";
				  					$solres = mysqli_query( $conn, $sol);
				  					$solrow = mysqli_num_rows( $solres);
				  				?>
				  				<?php if( $solrow === 0) { ?>
					  				<h4>No solution submited yet.</h4> <?php
					  			} else { ?>
					  				<div class="table-responsive">
					  					<table class="table">
					  						<tr>
					  							<th>Solution Name</th>
					  							<th>Uploader</th>
					  							<th>Uploaded</th>
					  							<th>Link</th>
					  						</tr> <?php
					  						 while( $solrow = mysqli_fetch_assoc( $solres)) { ?> 
					  							<tr>
					  								<td><?php echo $solrow['sol_name']; ?></td>
					  								<td><?php echo $solrow['sol_uploader']; ?></td>
					  								<td><?php echo $solrow['date_uploaded']; ?></td>
					  								<td>
					  									<div class="text-right">
					  										<?php $solPath = "../uploaded/solution/" . $solrow['sol_name'] . ".zip"; ?>
								  							<a type="button" class="btn btn-sm btn-success" href="<?php echo $solPath; ?>">Download</a>
								  							<a class="btn btn-sm btn-danger" href="../admin/deletesolution.php?ctfsolution=<?php echo $solrow['sol_name']; ?>">Delete</a> 
								  						</div>
								  					</td>
								  				</tr><?php
					  						}; ?>
					  					</table>
					  				</div><?php
					  			} ?>
				  			</div>
				  		</div> <?php
	  				} else { ?>
	  					<h4>CTF Game not Exist.</h4> <?php
	  				}?>
	  				<br><br>
	  			</div>
	  	
  	</body>
  	<script>
	  		var i = 0;
			var txt = document.getElementById("getDescription").value;
			var speed = 34; /* The speed/duration of the effect in milliseconds */

			function startConsole() {
				if (i < txt.length) {
				    document.getElementById("console-effect").innerHTML += txt.charAt(i);
				    i++;
				    setTimeout(startConsole, speed);
				}
			}
	  		function logout() {
				if( confirm("Are you sure?")) {
					window.location.href = "../user/logout.php";
				}
			}
		</script>
</html>