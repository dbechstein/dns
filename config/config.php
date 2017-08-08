<?php
	$mysql_db_hostname = "127.0.0.1";
	$mysql_db_user = "root";
	$mysql_db_password = "";
	$mysql_db_database = "mddns";

	$con = @mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password, $mysql_db_database);
	if (!$con) 
	{
		trigger_error('Could not connect to MySQL: '.mysqli_connect_error());
	}
?>