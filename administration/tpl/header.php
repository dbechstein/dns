<?php
	include('../session.php');
	include_once "functions.php";
	if($row['role'] != "Administrator") {
		header("Location: ../home.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>mdDNS - DNS-Verwaltung</title>
	<meta name="description" content="">
	<meta name="author" content="David Poland">
	<meta name="keywords" content="">
	<link href="css/style_logged_in.css" type="text/css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/functions.js"></script>
</head>
<body>
	<div id="containerr">
		<div class="container">
			<div id="logo">
				<img src="img/logo.gif" alt="Logo" class="logo-img">
							<ul style="float: right; color: #000; margin-top: 20px; list-style-type: none;">
				<li>Benutzer: <?php echo $vorname . " " . $row['nachname']; ?></li>
			</ul>
			</div>

			<nav>
				<div id="nav_head">
					<p>Navigation</p>
				</div>
				<ul>
						<li><a href="index.php">Startseite</a></li>
						<li><a href="userlist.php">Benutzer</a></li>
						<li><a href="tickets.php?sort=0&status=open">Offene Tickets (<?php get_ticket_num("open"); ?>)</a></li>
						<li><a href="tickets.php?sort=0&status=closed">Geschlossene Tickets (<?php get_ticket_num("closed"); ?>)</a></li>
						<li><a href="../home.php">Zur&uuml;ck</a></li>
				</ul>

			</nav>
