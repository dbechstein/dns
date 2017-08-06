<?php
include('config/config.php');
session_start(); // Starting Session
$error = "";
	if (isset($_POST['submit'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
		} else {
			// Define $username and $password
			$username=$_POST['username'];
			$password=$_POST['password'];
			// SQL query to fetch information of registerd users and finds user match.
			$sql = "select * from users where username='$username'";
			$query = mysqli_query($con, $sql);
			$obj = mysqli_fetch_array($query);
			$correct = password_verify($password, $obj['password']);
			if ($correct == true) {
				$tz = new DateTimeZone('Europe/Berlin');
				if(date('I')) {
					$datum = date('Y-m-d H:i:s');
				} else {
					$time1 = time() - 3600;
					$datum = date('Y-m-d H:i:s', $time1);
				}
				$sql_update = "UPDATE users SET last_login='$datum' where username='$username'";
				mysqli_query($con, $sql_update);
				$_SESSION['login_user']=$username; // Initializing Session
				$_SESSION['timestamp'] = $_SERVER['REQUEST_TIME'];
				header("location: home.php"); // Redirecting To Other Page
			} else {
				$error = '<li id="error"><p>Username or Password is invalid</p></li>';
			}
			mysqli_close($con); // Closing Connection
		}
	}
?>