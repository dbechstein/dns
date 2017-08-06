<?php
	include_once "tpl/header.php";
	//include_once "functions.php";
	$id = $_GET['id'];
?>
</div>
<div class="container">
<div id="content">
	<div style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;"><p style="margin-left: 10px; padding-top: 8px;">Ticket-Details</p></div>
	<div class="ticket_details" style="width: 862px; padding-top: 12px; border: 1px solid #9595A2; height: 70px;">
		<?php get_ticket_details($id); ?>
	</div>

	<div id="ticket_message_container" style="clear: both; margin-top: 20px;">
		<?php get_ticket_message($id); ?>
	</div>
	<?php get_comments($id); ?>
	<?php if($_GET["status"] != "closed") {
	echo '<div style="float: left; width: 100%; margin-top: 20px;">';
	echo '	<textarea class="comment" style="width: 862px; height: 150px; margin-bottom: 10px;"></textarea>';
	echo '	<label>Ticket geschlossen: </label>';
	echo '	<input class="checkbox" type="checkbox" />';
	echo '	<input style="display: none;" class="user_id" type="text" value="'.$user_id.'" />';
	echo '	<input style="display: none;" class="id" type="text" value="'.$id.'" />';
	echo '	<button onClick="sendComment();" style="float: right">Absenden</button>';
	echo ' </div>';
	} else {
		echo '<div style="float: left; width: 100%; margin-top: 20px;">';
		echo '	<label>Ticket öffnen: </label>';
		echo '	<input class="checkbox" type="checkbox" />';
		echo '	<input style="display: none;" class="user_id" type="text" value="'.$user_id.'" />';
		echo '	<input style="display: none;" class="id" type="text" value="'.$id.'" />';
		echo '	<button onClick="sendComment();" style="float: right">Absenden</button>';
		echo ' </div>';
	}
	?>
</div>
<script>
	function sendComment() {
		
		if(document.getElementsByClassName("checkbox")[0].checked == true)
		{
			var status = true;
			var comment = document.getElementsByClassName("comment");
			var user_id = document.getElementsByClassName("user_id");
			var id = document.getElementsByClassName("id");

			$.post("functions.php", {
				func: "send_comment",
				user_id: user_id[0].value,
				id: id[0].value,
				comment: comment[0].value,
				status: status
    			},
    			function(status){
				if(status == "success") {
        				window.location.href = "tickets.php?sort=0&status=open";
				} else if(status == "error") {
					alert("Fehler");
				}
			}
			);
		} else {
			var status = false;
			var user_id = document.getElementsByClassName("user_id");
			var id = document.getElementsByClassName("id");

			$.post("functions.php", {
				func: "send_comment",
				user_id: user_id[0].value,
				id: id[0].value,
				status: status
    			},
    			function(status){
				if(status == "success") {
        				window.location.href = "tickets.php?sort=0&status=open";
				} else if(status == "error") {
					alert("Fehler");
				}
			}
			);
		}

	}
</script>
<?php
	include_once "tpl/footer.php";
?>