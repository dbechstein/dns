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
		<?php get_ticket_details($id, $user_id); ?>
	</div>

	<div id="ticket_message_container" style="clear: both; margin-top: 20px;">
		<?php get_ticket_message($id, $user_id); ?>
	</div>
	<?php get_comments($id, $user_id); ?>
	<div style="float: left; width: 100%; margin-top: 20px;">
		<textarea class="comment" style="width: 862px; height: 150px; margin-bottom: 10px;"></textarea>
		<label>Ticket geschlossen: </label>
		<input class="checkbox" type="checkbox" />
		<input style="display: none;" class="user_id" type="text" value="<?php echo $user_id; ?>" />
		<input style="display: none;" class="id" type="text" value="<?php echo $id; ?>" />
		<button onClick="sendComment();" style="float: right">Absenden</button>
	</div>
</div>
<script>
	function sendComment() {
		var comment = document.getElementsByClassName("comment");
		if(document.getElementsByClassName("checkbox")[0].checked == true)
		{
			var status = true;
		} else {
			var status = false;
		}
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
        			alert("Domain hinzugefuegt");
			} else if(status == "error") {
				alert("Fehler");
			}
		}
		);
	}
</script>
<?php
	include_once "tpl/footer.php";
?>