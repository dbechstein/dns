<?php
	include_once "tpl/header.php";
	include_once "functions.php";
?>

<div class="container">
<div id="content">
	<div style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;"><p style="margin-left: 10px; padding-top: 8px;">Neues Ticket</p></div>
	<form>
		<ul style="width: 700px; margin: 10px auto; list-style-type: none;">
			<li style="display: none;">
				<input class="user_id" style="width: 548px; height:25px;" type="text" value="<?php echo $user_id; ?>" />
			</li>
			<li style="margin-bottom: 5px;">
				<label style="float: left; width: 150px; height: 25px;">Domain: </label>
				<select style="width: 550px; height: 25px;" class="domain" size="1">
					<?php get_domains($user_id, "ticket"); ?>
				</select>
			</li>
			<li style="margin-bottom: 5px;">
				<label style="float: left; width: 150px; height: 25px;">Kategorie: </label>
				<select style="width: 550px; height: 25px;" class="type" size="1">
					<option>Allgemein</option>
					<option>Fehler</option>
				</select>
			</li>
			<li style="margin-bottom: 5px;">
				<label style="float: left; width: 150px; height: 25px;">Betreff: </label>
				<input class="betreff" style="width: 548px; height:25px;" type="text" />
			</li>
			<li>
				<textarea class="message" style="width: 698px; height: 300px;"></textarea>
			</li>
			<li>
				<button onClick="addTicket(this)" style="float: right; margin-top: 5px; height: 30px;">Absenden</button>
			</li>
		</ul>
	</form>
</div>
<?php
	include_once "tpl/footer.php";
?>