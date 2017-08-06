<?php
	include_once "tpl/header.php";
	include_once "functions.php";
?>
	</div>
	<div class="container">
		<div id="content">
			<div style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;"><p style="margin-left: 10px;">Domains hinzuf&uuml;gen:</p></div>
			<input class="user_id" type="hidden" value="<?php echo $user_id; ?>"><input class="domain" id="domain" name="domain" placeholder="Domain" type="text"><button onclick="add_domain(this)">Domain hinzuf&uuml;gen</button>
		</div>
<?php
	include_once "tpl/footer.php";
?>