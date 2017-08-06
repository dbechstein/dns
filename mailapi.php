<?php
	$mysql_db_hostname = "192.168.164.4";
	$mysql_db_user = "root";
	$mysql_db_password = "CD5455dd";
	$mysql_db_database = "vimbadmin";

	$con = @mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password, $mysql_db_database);
	if (!$con) 
	{
		trigger_error('Could not connect to MySQL: '.mysqli_connect_error());
	}

	$username = $_GET['username'];
	$password = $_GET['password'];
	$name = $_GET['name'];
	$alt_email = $_GET['alt_email'];
	$quota = $_GET['quota'];
	$domain = $_GET['domain'];

	$sql = "SELECT id FROM domain WHERE domain = $domain";
	$result = mysqli_query($con, $sql);
	while($obj = mysqli_fetch_array($result)) 
		{
			echo $obj["id"];
		}	
	
?>