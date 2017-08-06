<?php
include("login.php"); // Includes Login Script

if(isset($_SESSION['login_user'])){
header("location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>q2h.de - DNS-Verwaltung</title>
	<meta name="description" content="">
	<meta name="author" content="David Poland">
	<meta name="keywords" content="">
	<link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div class="container_haupt">
		<div class="container">		
			<div id="logo"></div>
			<div id="login">
				<form action="" method="post">
					<ul>
						<li><label>Username :</label></li>
						<li><input id="name" name="username" placeholder="username" type="text"></li>
						<li><label>Password :</label></li>
						<li><input id="password" name="password" placeholder="**********" type="password"></li>
						<li><button name="submit" type="submit" value=" Login ">Login</button></li>
						<?php echo $error; ?>
					</ul>
				</form>
			</div>
		</div>
	</div>
</body>
</html>