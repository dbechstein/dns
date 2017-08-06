<?php
	include_once('config/config.php');
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter

	// Selecting Database
	session_start();// Starting Session
	
	// Storing Session
	$user_check=$_SESSION['login_user'];
	$_SESSION['logged_in'] = true;
	
	// SQL Query To Fetch Complete Information Of User
	$ses_sql=mysqli_query($con, "select * from users where username='$user_check'");
	$row = mysqli_fetch_assoc($ses_sql);
	$user_id =$row['id'];
	//$timestamp = $row['last_login'];
	$login_session =$row['username'];
	$vorname = $row['vorname'];
	
	if(!isset($login_session)){
		mysqli_close($con); // Closing Connection
		header('Location: index.php'); // Redirecting To Home Page
	}
	//echo $sql_update = "UPDATE users SET last_login='$datum' where username='$user_check'";
	//echo date("Y-m-d H:i:s"); 
	//echo $sql_update = "UPDATE users SET last_login="' . date("Y-m-d H:i:s") . '" where username='$user_check'";
	//mysqli_query($con, $sql_update);
	//echo time() - $timestamp;
	if($row['role'] != "Administrator") {
 		if(time() - $_SESSION['timestamp'] > 1800) { //subtract new timestamp from the old one
    			unset($_SESSION['login_user']);
    			$_SESSION['logged_in'] = false;
    			header('Location: index.php'); //redirect to index.php
    			exit;
		} else {
			$_SESSION['timestamp'] = time(); //set new timestamp
		}
	}
?>