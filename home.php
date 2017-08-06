<?php
	include_once "tpl/header.php";
	include_once "functions.php";
?>
</div>
<div class="container">
<div id="content">
	<div style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;"><p style="margin-left: 10px;">Ihre Domains:</p></div>
	<p style="margin-top: 10px;">Hallo Herr <?php echo $row['nachname']; ?></p><br />
	<p>im Folgenden finden Sie Ihre aktuellen Domains:</p><br />
	<?php get_domains($user_id,''); ?>
</div>
<?php
	include_once "tpl/footer.php";
?>