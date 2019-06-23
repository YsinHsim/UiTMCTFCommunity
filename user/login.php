<?php
	include('../config/config.php'); //$conn

	if(isset($_POST['operation'])) {
		$operation = mysqli_real_escape_string( $conn, $_POST['operation']);
		if( $operation == "login") {
			$name = mysqli_real_escape_string( $conn, $_POST['user']);
			$pass = mysqli_real_escape_string( $conn, $_POST['pass']);

			$query = "SELECT * FROM user WHERE username = '$name' and pass = '$pass'";
			$res = mysqli_query( $conn, $query);
			$row = mysqli_num_rows($res);

			if($row === 1) {

				$checkque = "SELECT * FROM user WHERE username = '$name' and pass = '$pass'";
				$checkres = mysqli_query( $conn, $checkque);
				$checkrow = $checkres -> fetch_assoc();

				if( $checkrow['user_status'] != "Active") {
					echo "<script>alert('You have been banned by administrator. Contact admin to pwn.');window.location='../user/login.php';</script>";
				}

				$current_date = date('d-m-Y');
				$current_time = date("h:i:sa");

				$query2 = "UPDATE user SET last_login_time = '".$current_time."', last_login_date = '".$current_date."' WHERE username = '$name'";
				$res2 = mysqli_query( $conn, $query2);

				session_start();
				$_SESSION['name'] = $name;
				$_SESSION['status'] = "login";
				//redirect user to ctflist.php
				header("Location: ../main/ctflist.php");
				die();
			}
			else {
				echo "<script> alert('Username or Password is incorrect! Please try again.');</script";
			}
		}
		else if( $operation == "register") {
			$name = mysqli_real_escape_string( $conn, $_POST['user']);
			$pass = mysqli_real_escape_string( $conn, $_POST['pass']);
			$confirmpass = mysqli_real_escape_string( $conn, $_POST['confirmpass']);
			$email = mysqli_real_escape_string( $conn, $_POST['email']);

			if( $pass == $confirmpass) {
				$query2 = "INSERT INTO user( username, pass, email) VALUES ('$name','$pass','$email')";
				if( mysqli_query( $conn, $query2)) {
					echo "<script>alert('Registration complete! Please login to start pwning.');</script>";
				}
				else {
					echo "<script>alert('It seem username has been taken. Please try again.');</script>";
				}
			}
			else {
				echo "<script>alert('Your password is not match! Please try again.');</script>";
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

		<link rel="stylesheet" href="../style/style.css">
  	</head>

  	<body>
  		<div id="form-position" class="container-fluid">
  			<div class="col-lg-2"></div>
  			<div class="col-lg-3" id="toogle-form">
  				<form method="post" action="../user/login.php">
		  				<div class="row">
		  					<h3>Login</h3>
		  				</div><br>
		  				<input type="text" name="operation" value="login" hidden>
		  				<div class="row">
		  					<input type="text" name="user" class="form-control" placeholder="Enter Username" required>
		  				</div><br>
		  				<div class="row">
		  					<input type="password" name="pass" class="form-control" placeholder="Enter Password" required>
		  				</div><br>
		  				<div class="row text-right">
		  					<input type="submit" value="Login" class="btn btn-primary">
		  				</div>
		  		</form>
	  		</div>
	  		<div class="col-lg-2"></div>
	  		<div class="col-lg-4">
	  			<div class="row">
	  				<h3>Welcome to UiTM CTF Community</h3>
	  			</div><br>
	  			<div class="row">
	  				<p>Made with love by <a href="https://github.com/YsinHsim" target="_blank" id="githubLink">YsinHsim</a>, inspired by crackmes.one</p>
	  				<p>Register to start play with our CTF Game.</p>
	  				<p>For any problem you can contact us at yasinhassim43@gmail.com</p>
	  			</div><br>
	  			<div class="row">
	  				<button id="toogle-button" type="button" class="btn btn-success">Register Here</button>
	  			</div>
	  		</div>
	  	</div>
	  			<span id="login" style="display: none;">
	  				<form method="post" action="../user/login.php">
		  				<div class="row">
		  					<h3>Login</h3>
		  				</div><br>
		  				<input type="text" name="operation" value="login" hidden>
		  				<div class="row">
		  					<input type="text" name="user" class="form-control" placeholder="Enter Username" required>
		  				</div><br>
		  				<div class="row">
		  					<input type="password" name="pass" class="form-control" placeholder="Enter Password" required>
		  				</div><br>
		  				<div class="row text-right">
		  					<input type="submit" value="Login" class="btn btn-primary">
		  				</div>
		  			</form>
		  		</span>
		  		<span id="register" style="display: none;">
		  			<form method="post" action="../user/login.php">
		  				<div class="row">
		  					<h3>Register</h3>
		  				</div><br>
		  				<input type="text" name="operation" value="register" hidden>
		  				<div class="row">
		  					<input type="text" name="user" class="form-control" placeholder="Enter Username" required>
		  				</div><br>
		  				<div class="row">
		  					<input type="password" name="pass" class="form-control" placeholder="Enter Password" required>
		  				</div><br>
		  				<div class="row">
		  					<input type="password" name="confirmpass" class="form-control" placeholder="Confirm Password" required>
		  				</div><br>
		  				<div class="row">
		  					<input type="email" name="email" class="form-control" placeholder="Enter Email" required>
		  				</div><br>
		  				<div class="row text-right">
		  					<input type="submit" value="Register" class="btn btn-success">
		  				</div>
		  			</form>
		  		</span>
  	</body>
  	<script>
  		document.getElementById("toogle-button").setAttribute( "onclick", "toogleRegister()");
  		function toogleRegister() {
  			document.getElementById("toogle-form").innerHTML = document.getElementById("register").innerHTML;
  			document.getElementById("toogle-button").innerHTML = "Login Here";
  			document.getElementById("toogle-button").className = "btn btn-primary";
  			document.getElementById("toogle-button").setAttribute( "onclick", "toogleLogin()");
  		}
  		function toogleLogin() {
  			document.getElementById("toogle-form").innerHTML = document.getElementById("login").innerHTML;
  			document.getElementById("toogle-button").innerHTML = "Register Here";
  			document.getElementById("toogle-button").className = "btn btn-success";
  			document.getElementById("toogle-button").setAttribute( "onclick", "toogleRegister()");
  		}
  	</script>
</html>
