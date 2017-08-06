<?php
	include('session.php');
	include_once "functions.php";	
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
				<ul style="float: right; color: #000; margin-top: 20px; list-style-type: none; text-align: right;">
				<li>Benutzer: <?php echo $vorname . " " . $row['nachname']; ?></li>
				<li>Eingeloggt seit: <?php echo $row['last_login']; ?></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
			</div>

			<nav>
				<div id="nav_head">
					<p>Navigation</p>

				</div>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="domainadd.php">Domain hinzuf&uuml;gen</a></li>
					<li>DNS-Verwaltung</li>
					<ul style="margin-left: 10px;">
						<?php get_domains($user_id, ''); ?>
					</ul>
					<?php 
						if($row['role'] == "Administrator") {
							echo '<li><a href="administration/index.php">Administration</a>';
						} else {
							$open = get_ticket_num("open", $user_id);
							$closed = get_ticket_num("closed", $user_id);
							echo '<li><a href="new_ticket.php">Neues Ticket</a></li>';
							echo '<li><a href="tickets.php?sort=0&status=open">Offene Tickets ('.$open.')</a></li>';
							echo '<li><a href="tickets.php?sort=0&status=closed">Geschlossene Tickets ('.$closed.')</a></li>';

						}
					?>
					<li><a href="logout.php">Logout</a></li>

				</ul>

			</nav>