<?php
	include_once "tpl/header.php";
	//include_once "functions.php";
	$sort = $_GET['sort'];
	$status= $_GET['status'];
?>
</div>
<div class="container">
<div id="content">
	<!--<div style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;"><p style="margin-left: 10px; margin-top: 20px;">Administration</p></div>-->
	<ul class="ticket_header">				
		<li style="width: 50px;" class="t_id"><p>Ticket-ID:</p></li>
		<li style="width: 454px;" class="t_title"><p>Titel:</p></li>
		<li style="width: 100px;" class="t_author"><p>Author:</p></li>
		<li style="width: 260px;" class="t_date"><p>Erstellt am:</p></li>
	</ul>
	<ul class="ticket_content">
		<?php get_tickets($sort, $status, $user_id) ?>
	</ul>
</div>
<?php
	include_once "tpl/footer.php";
?>