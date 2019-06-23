<?php include('../config/config.php'); //$conn

	session_start();
	$name = $_SESSION['name'];

	$query = "SELECT * FROM user WHERE username = '$name'";
	$res = mysqli_query( $conn, $query);
	$row = mysqli_num_rows($res);

	if($row === 0) {
		//USER TRY TO NAVIGATE TO THIS PAGE WITHOUT PASS THROUGH LOGIN PAGE
		echo "<script>alert('Please login to proceed.');window.location='../user/login.php'</script>";
		die();
	}

	$ctf = "SELECT * FROM crackfile";
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

  	<body>
  		<nav class="navbar navbar-inverse">
  			<div class="container-fluid">
  				<div class="navbar-header">
  					<a id="brand" class="navbar-brand" onclick="welcome()">UiTM CTF Community</a>
  				</div>
	  			<ul class="nav navbar-nav">
	  				<li><a href="ctflist.php">CTF List</a></li>
	  				<li class="active"><a href="ctfupload.php">CTF Upload</a></li>
	  				<li><a href="flagsubmit.php">Flag Submit</a></li>
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
		  		<h2>Upload Your CTF Game</h2>
			  	<p id="warningFont">For first timer, we recommend you to read the instruction. There are necessary things to know before uploading your own game.</p><br>
			  	
				<form method="post" action="uploadctfprocess.php" enctype="multipart/form-data" autocomplete="off">
			  		<div class="row">
			  			<input class="form-control" name="ctfname" placeholder="Enter CTF Name" required>
			  		</div><br>
			  		<div class="row">
			  			<select id="platform" class="form-control" name="ctfplatform">
			  				<option value="Windows">Windows</option>
			  				<option value="Unix/Linux">Unix/Linux</option>
			  				<option value="default" hidden selected>Select Platform</option>
			  			</select>
			  		</div><br>
			  		<div class="row">
			  			<select id="language" class="form-control" name="ctflanguage">
			  				<option value="Assembler">Assembler</option>
			  				<option value="C/C++">C/C++</option>
			  				<option value=".NET">.NET</option>
			  				<option value="Visual Basic">Visual Basic</option>
			  				<option value="default" hidden selected>Select Language</option>
			  			</select>
			  		</div><br>
			  		<div class="row">
			  			<select id="level" class="form-control" name="ctflevel">
			  				<option value="Very Easy">Very Easy</option>
			  				<option value="Easy">Easy</option>
			  				<option value="Average">Average</option>
			  				<option value="Hard">Hard</option>
			  				<option value="Very Hard">Very Hard</option>
			  				<option value="default" hidden selected>Select Level</option>
			  			</select>
			  		</div><br>
			  		<div class="row">
			  			<input name="ctfflag" class="form-control" placeholder="Enter CTF Flag" required>
			  		</div><br>
			  		<div class="row">
			  			<textarea name="ctfdesc" class="md-textarea form-control" placeholder="Enter CTF Game Description"></textarea>
			  		</div><br>
			  		<div class="row">
			  			<input name="ctffile" class="form-horizontal" type="file" required>
			  		</div><br>
			  		<div class="row text-right">
			  			<input type="submit" class="btn btn-primary" value="Upload">
			  		</div><br>
			  	</form>
			</div>
			<div class="col-lg-2"></div>
			<div class="col-lg-5">
				<br><br><br>
				<button type="button" class="btn btn-info" onclick="uploadInstruction()">Click Here to See Instruction.</button>
				<br><br>
				<div id="uploadInstruction">

				</div><br><br>
				<div id="uploadInstruction2">
					
				</div>
			</div>
	  	</div>
	  	<script type="text/javascript">
	  		var onoff = 0; //on if detail can be seen, off otherwise
	  		function uploadInstruction() {
	  			if( onoff == 0) {
	  				onoff = 1;
	  				var text = "1. Enter all the form detail to submit your CTF Game.<br>2. Including readme.txt file into your zip file as as instruction for other player is recommended.<br>3. Obvious flag for your CTF Game is recommended for easy level.<br>4. Length of your CTF flag must less than 42.<br>5. Please select your <b id='fontBold'>Platform</b>, <b id='fontBold'>Language</b> and <b id='fontBold'>Level</b>. CTF description is optional.<br>6. Make sure to compress as .zip before upload your CTF game. Any file other than .zip extension will be delete."
	  				var text2 = "You can do reverse engineering, but you can't do reserve hacking.<br>~ Franchis Chick";

		  			document.getElementById("uploadInstruction").style.color = "#7fa9ee";
		  			document.getElementById("uploadInstruction2").style.color = "#0bd423";
		  			document.getElementById("uploadInstruction").innerHTML = text;
		  			document.getElementById("uploadInstruction2").innerHTML = text2;
	  			}
		  		else if( onoff == 1) {
		  			onoff = 0;
		  			var text = "";
		  			document.getElementById("uploadInstruction").innerHTML = text;
		  			document.getElementById("uploadInstruction2").innerHTML = text;
		  		}
	  		}
	  		function logout() {
				if( confirm("Are you sure?")) {
					window.location.href = "../user/logout.php";
				}
			}
	  	</script>
  	</body>
</html>
