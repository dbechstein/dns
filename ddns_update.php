<?php
include('admin/config/config.php');
$ip = $_SERVER['REMOTE_ADDR'];
$username = $_GET['username'];
$password = $_GET['password'];
$url = $_GET['url'];

$sql_date_select = "SELECT change_date FROM records INNER JOIN users Where users.username = '$username' AND users.password = '$password' AND records.name = '$url'";
$result = mysqli_query($con, $sql_date_select);
$sql_date = mysqli_fetch_row($result);

if($sql_date[0] < time()) {
	$sql_update = "UPDATE records SET content = '$ip' WHERE name='$url'";
	mysqli_query($con, $sql_update);
}
?>