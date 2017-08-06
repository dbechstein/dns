<?php
	function get_ticket_num($status) {
		include('../config/config.php');
		if($status == "open") {
			$status = ">";
		} else {
			$status = "=";
		}
		$sql ="SELECT id FROM tickets WHERE is_active $status 0";
		//echo $sql = "SELECT * FROM records AS r INNER JOIN (users AS u INNER JOIN user_domains AS ud ON u.id=ud.user_id) INNER JOIN domain_records AS dr ON r.id=dr.records_id WHERE u.id='$user_id' AND dr.domain_id='$dom_id' AND r.domain_id='$dom_id'";
		$result = mysqli_query($con, $sql);
		$rows = mysqli_num_rows($result);
		echo $rows;	
	}

	function get_tickets($sort, $status) {
		include('../config/config.php');
		if($status == "open") {
			$stati = ">";
		} else {
			$stati = "=";
		}
		if($sort == 1) {
			$sql ="SELECT t.id, t.title, t.created_at, t.message, t.user_id, u.email, u.username FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE is_active $stati 0 ORDER BY t.id ASC";
		} else if($sort == 2) {
			$sql ="SELECT t.id, t.title, t.created_at, t.message, t.user_id, u.email, u.username FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE is_active $stati 0 ORDER BY t.id DESC";
		} else{
			$sql ="SELECT t.id, t.title, t.created_at, t.message, t.user_id, u.email, u.username FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE is_active $stati 0";
		}
		//echo $sql = "SELECT * FROM records AS r INNER JOIN (users AS u INNER JOIN user_domains AS ud ON u.id=ud.user_id) INNER JOIN domain_records AS dr ON r.id=dr.records_id WHERE u.id='$user_id' AND dr.domain_id='$dom_id' AND r.domain_id='$dom_id'";
		$result = mysqli_query($con, $sql);
		//$num = mysqli_num_rows($result);
		//$tickets = mysqli_fetch_array($result);
		while($obj = mysqli_fetch_array($result)) 
		{
			echo '<li style="width: 100%;"><p style="width: 50px; color: #000;">'.$obj["id"].'</p>';
			echo '<p style="width: 454px;color: #000;"><a href="show_ticket.php?id='.$obj["id"].'&status='.$status.'">'.$obj["title"].'</a></p>';
			echo '<p style="width: 100px;color: #000;">'.$obj["username"].'</p>';
			echo '<p style="width: 260px;color: #000;">'.$obj["created_at"].'</p></li>';
		}	
	}

	function get_ticket_details($id) {
		include('../config/config.php');
		$sql ="SELECT t.title, t.created_at, u.username, t.domain, t.categorie FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE t.id='$id'";
		//$sql_comments = "SELECT t.id, c.ticket_id, c.comment, c.created_at, c.user_id FROM comments AS c INNER JOIN tickets AS t ON c.ticket_id=t.id WHERE c.ticket_id='$id'"; 
		$result = mysqli_query($con, $sql);
		$obj = mysqli_fetch_array($result);
		echo '<ul class="ticket_details_left" style="list-style-type: none; float: left; min-width: 300px; margin-left: 5px;">';
		echo '	<li><b>Titel:</b> '.$obj["title"].'</li>';
		echo '	<li><b>Username:</b> '.$obj["username"].'</li>';
		echo '	<li><b>Domain:</b> '.$obj["domain"].'</li>';
		echo '</ul>';
		echo '<ul class="ticket_details_right" style="list-style-type: none; float: left; min-width: 300px;">';
		echo '	<li><b>Kategorie:</b> '.$obj["categorie"].'</li>';
		echo '	<li><b>Erstellt am:</b> '.$obj["username"].'</li>';
		echo '</ul>';
	}

	function get_ticket_message($id) {
		include('../config/config.php');
		$sql ="SELECT u.username, t.message, t.created_at FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE t.id='$id'";
		//$sql_comments = "SELECT t.id, c.ticket_id, c.comment, c.created_at, c.user_id FROM comments AS c INNER JOIN tickets AS t ON c.ticket_id=t.id WHERE c.ticket_id='$id'"; 
		$result = mysqli_query($con, $sql);
		$obj = mysqli_fetch_array($result);
		echo '<div id="ticket_message_header" style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;">';
		echo '	<p style="float: left; margin-left: 10px; padding-top: 8px;">'.$obj["username"].'</p>';
		echo '	<p style="float: right; margin-right: 10px; padding-top: 8px;">Erstellt am: '.$obj["created_at"].'</p>';
		echo '</div>';
		echo '<div id="ticket_message" style="width: 862px; border: 1px solid #9595A2;">';
		echo '	<pre>'.$obj["message"].'</pre>';
		echo '</div>';
	}

	function get_comments($id) {
		include('../config/config.php');
		$sql ="SELECT c.comment, c.created_at, u.username, u.role FROM comments AS c INNER JOIN users AS u ON c.user_id=u.id INNER JOIN tickets AS t ON t.id=ticket_id WHERE t.id='$id'";
		$result = mysqli_query($con, $sql);
		while($obj = mysqli_fetch_array($result)) 
		{
			if($obj["role"] == "Administrator") {
				echo '<div id="comment_message_container" style="float: left;">';
				echo '<div id="comment_message_header" style="float: right; width: 800px; background-color: #9595A2; height: 35px; color: #fff; margin-top: 10px;">';
				echo '	<p style="float: left; margin-left: 10px; padding-top: 8px;">'.$obj["username"].'</p>';
				echo '	<p style="float: right; margin-right: 10px; padding-top: 8px;">Erstellt am: '.$obj["created_at"].'</p>';
				echo '</div>';
				echo '<div id="comment_message" style="float: right; width: 798px; border: 1px solid #9595A2;">';
				echo '	<pre>'.$obj['comment'].'</pre>';
				echo '</div>';
				echo '</div>';
			} else {
				echo '<div id="comment_message_container" style="float: left;">';
				echo '<div id="comment_message_header" style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 10px;">';
				echo '<p style="float: left; margin-left: 10px; padding-top: 8px;">'.$obj["username"].'</p>';
				echo '<p style="float: right; margin-right: 10px; padding-top: 8px;">Erstellt am: '.$obj["created_at"].'</p>';
				echo '</div>';
				echo '<div id="comment_message" style="width: 862px; border: 1px solid #9595A2;">';
				echo '<pre>'.$obj["comment"].'</pre>';
				echo '</div>';
				echo '</div>';
			}
		}
	}

	function send_comment($id, $status, $comment, $user_id) {
		include('../config/config.php');
		if($status == "true") {
			$sql_update = "UPDATE tickets SET is_active=0 WHERE id='$id'";
			mysqli_query($con, $sql_update);
			if(date('I')) {
				$datum = date('Y-m-d H:i:s');
			} else {
				$time1 = time() - 3600;
				$datum = date('Y-m-d H:i:s', $time1);
			}
			$sql = "INSERT INTO comments (ticket_id, user_id, comment, created_at) VALUES ('$id','$user_id','$comment','$datum')";
			mysqli_query($con, $sql);
		} else {
			$sql_update = "UPDATE tickets SET is_active=1 WHERE id='$id'";
			mysqli_query($con, $sql_update);
		}
		
	}

	function get_user_list() {
		include('../config/config.php');
		$sql ="SELECT * FROM users ";
		//echo $sql = "SELECT * FROM records AS r INNER JOIN (users AS u INNER JOIN user_domains AS ud ON u.id=ud.user_id) INNER JOIN domain_records AS dr ON r.id=dr.records_id WHERE u.id='$user_id' AND dr.domain_id='$dom_id' AND r.domain_id='$dom_id'";
		$result = mysqli_query($con, $sql);
		//$num = mysqli_num_rows($result);
		//$tickets = mysqli_fetch_array($result);
		while($obj = mysqli_fetch_array($result)) 
		{
			echo '<ul>';
			echo '<li style="margin-bottom: 5px;">'.$obj["username"].'<button style="float: right;" type="submit" name="action" onClick="toggle('.$obj["id"].')">Bearbeiten</button></li>';
			echo '<ul id="'.$obj["id"].'">';
			echo '<li class="user_id" style="display: none;">'.$obj["id"].'</li>';
			echo '<li><label>Vorname: </label><input class="vorname" type="text" value="'.$obj["vorname"].'" /></li>';
			echo '<li><label>Nachname: </label><input class="nachname" type="text" value="'.$obj["nachname"].'" /></li>';
			echo '<li><label>E-Mail: </label><input class="email" type="text" value="'.$obj["email"].'" /></li>';
			echo '<li><label>Rolle: </label><select class="role" name="Rolle" size="1" id="role"><option>User</option><option>Administrator</option></select>';
			echo '<li><button type="submit" name="action" onClick="save_user(this)">Speichern</button></li>';
			echo '</ul>';	
			echo '</ul>';
		}
	}

	if(isset($_POST['func'])) {
		$postFunction = $_POST['func'];
		if($postFunction == "save_user") {
			$user_id = $_POST['user_id'];
			$vorname = $_POST['vorname'];
			$nachname= $_POST['nachname'];
			$email = $_POST['email'];
			$role = $_POST['role'];
			save_user($user_id, $vorname, $nachname, $email, $role);
			echo "success";
		}
		
		if($postFunction == "send_comment") {
			$id = $_POST['id'];
			$user_id = $_POST['user_id'];

			$status = $_POST['status'];
			if($status == "true") {
				$comment = $_POST['comment'];
				send_comment($id, $status, $comment, $user_id);
			} else {
				send_comment($id, $status, '', $user_id);
			}
			echo "success";
		}
	}	

	function save_user($user_id, $vorname, $nachname, $email, $role) {
		include('../config/config.php');
		$sql = "UPDATE users SET vorname='$vorname', nachname='$nachname', email='$email', role='$role' WHERE id='$user_id'";
		mysqli_query($con, $sql);
	}
?>