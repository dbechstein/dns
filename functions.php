<?php
	function get_record_values($user_id,$dom_id) {
		include('config/config.php');
		$sql ="SELECT * FROM records AS r JOIN user_domains AS ud WHERE ud.user_id=$user_id AND ud.domain_id=r.domain_id AND r.domain_id='$dom_id'";
		//echo $sql = "SELECT * FROM records AS r INNER JOIN (users AS u INNER JOIN user_domains AS ud ON u.id=ud.user_id) INNER JOIN domain_records AS dr ON r.id=dr.records_id WHERE u.id='$user_id' AND dr.domain_id='$dom_id' AND r.domain_id='$dom_id'";
		$result = mysqli_query($con, $sql);
		$rows = mysqli_num_rows($result);
		while($obj = mysqli_fetch_array($result)) 
		{
			echo '<ul id="record_'.$obj["id"].'" class="record_content"><li><input class="user_id" type="hidden" value="'.$obj["user_id"].'"><input class="record_id" type="hidden" value="'.$obj["id"].'"><input class="dom_id" type="hidden" value="'.$obj["domain_id"].'"><input class="record_name" type="text" value="'.$obj["name"].'" maxlength="30"></li><li><input class="record_type" type="hidden" value="'.$obj["type"].'" maxlength="30"><select class="recordss"><option id="Select">Please Select</option><option id="record_SOA"'; 
			if($obj['type'] == 'SOA') echo ' selected';
			echo '>SOA</option><option id="record_NS"';
			if($obj['type'] == 'NS') echo ' selected';
			echo '>NS</option><option id="record_A"';
			if($obj['type'] == 'A') echo ' selected';
			echo '>A</option><option id="record_CNAME"';
			if($obj['type'] == 'CNAME') echo ' selected';
			echo '>CNAME</option><option id="record_MX"';
			if($obj['type'] == 'MX') echo ' selected';
			echo '>MX</option><option id="record_txt"';
			if($obj['type'] == 'TXT') echo ' selected';
			echo '>TXT</option></select></li><li><input class="record_value" type="text" value="'.$obj["content"].'"></li><li><input class="record_prio" type="text" id="username" value="'.$obj["prio"].'"></li><li><input class="record_ttl" type="text" id="username" value="'.$obj["ttl"].'" maxlength="5"></li><li><button id="save" onclick="save(this)">Speichern</button><button id="del" style="width: 24px; color: #fff;" onclick="del(this)">X</button></li></ul>';
		}	
	}

	function updateSOA($user_id, $dom_id) {
		$sql_soa = "SELECT content FROM records AS r JOIN user_domains AS ud WHERE ud.user_id=$user_id AND ud.domain_id=r.domain_id AND r.domain_id='$dom_id' AND r.type ='SOA'";
		$result = mysqli_query($con, $sql_soa);
		$obj = mysqli_fetch_array($result);
		$teile = explode(" ", $obj['content']);
		$content = $teile[2] + 1;
		$content_update = $teile[0] . ' ' . $teile[1] . ' ' . $content . ' ' . $teile[3] . ' ' . $teile[4] . ' ' . $teile[5] . ' ' . $teile[6];
		$sql_soa_up = "UPDATE records AS r SET content='$content_update' WHERE type='SOA' AND r.domain_id='$dom_id'";
		mysqli_query($con, $sql_soa_up);
	}

	function save_record_values($user_id,$dom_id,$record_id,$name,$type,$value,$prio,$ttl) {
		include('config/config.php');
		if ($type != "SOA") {
			updateSOA($user_id, $dom_id);
		}
		$sql = "UPDATE records AS r  SET name='$name', r.domain_id='$dom_id', type='$type', content='$value', prio='$prio', ttl='$ttl' WHERE r.domain_id='$dom_id' AND r.id='$record_id'";

		mysqli_query($con, $sql);	

	}

	function insert_record_values($user_id,$dom_id,$name,$type,$value,$prio,$ttl) {
		include('config/config.php');
		$sql = "INSERT INTO records (domain_id,name,type,content,prio,ttl) VALUES ('$dom_id','$name','$type','$value','$prio','$ttl')";
		mysqli_query($con, $sql);	
		$sql_fk = "INSERT INTO domain_records (domain_id, records_id) VALUES('$dom_id', (SELECT id FROM records WHERE name ='$name'))";
		mysqli_query($con, $sql_fk);
		updateSOA($user_id, $dom_id);
	}

	function del_record_values($record_id) {
		include('config/config.php');
		$sql_foreign_del = "DELETE FROM domain_records WHERE records_id='$record_id'";
		mysqli_query($con, $sql_foreign_del);	
		$sql = "DELETE FROM records WHERE id='$record_id'";
		mysqli_query($con, $sql);
		updateSOA($user_id, $dom_id);	
	}

	function add_domain($user_id,$domain) {
		include('config/config.php');
		$sql_check_domain = "SELECT name FROM domains WHERE name='$domain'";
		$result = mysqli_query($con, $sql_check_domain);
		$obj = mysqli_fetch_array($result);
		if($obj['name'] != $domain) {
			$sql = "INSERT INTO domains (name,master,type,account) VALUES ('$domain','192.168.139.193','MASTER',1)";
			mysqli_query($con, $sql);
			$sql_fk = "INSERT INTO user_domains (user_id, domain_id) VALUES($user_id, (SELECT id FROM domains WHERE name='$domain'))";
			mysqli_query($con, $sql_fk);
			$soa = "ns1.q2h.de. admin@mydato.de. " . date('Ymd') . "01 10800 3600 604800 300";
			$sql_records_soa = "INSERT INTO records (domain_id,name,type,content,prio,ttl) VALUES ((SELECT id FROM domains WHERE name='$domain'),'$domain','SOA','$soa','0','3600')";
			mysqli_query($con, $sql_records_soa);	
			$sql_records_ns1 = "INSERT INTO records (domain_id,name,type,content,prio,ttl) VALUES ((SELECT id FROM domains WHERE name='$domain'),'$domain','NS','ns1.q2h.de','0','3600')";
			mysqli_query($con, $sql_records_ns1);
			$sql_records_ns2 = "INSERT INTO records (domain_id,name,type,content,prio,ttl) VALUES ((SELECT id FROM domains WHERE name='$domain'),'$domain','NS','ns2.q2h.de','0','3600')";
			mysqli_query($con, $sql_records_ns2);
			echo "success";
		} else {
			echo "error";
		}
	}
	
	function add_ticket($user_id, $domain, $type, $title, $message) {
		include('config/config.php');
		if(date('I')) {
			$datum = date('Y-m-d H:i:s');
		} else {
			$time1 = time() - 3600;
			$datum = date('Y-m-d H:i:s', $time1);
		}
		$sql = "INSERT INTO tickets (user_id, domain, categorie, title, message, created_at, is_active) VALUES ('$user_id','$domain','$type','$title','$message','$datum',1)";
		mysqli_query($con, $sql);
	}

	function del_domain($dom_id) {
		include('config/config.php');
		$sql_foreign1_del = "DELETE FROM domain_records WHERE domain_id='$dom_id'";
		$sql_foreign2_del = "DELETE FROM user_domains WHERE domain_id='$dom_id'";
		$sql_del = "DELETE FROM records WHERE domain_id='$dom_id'";
		$sql_del_dom = "DELETE FROM domains WHERE id='$dom_id'";
		mysqli_query($con, $sql_foreign1_del);
		mysqli_query($con, $sql_foreign2_del);
		mysqli_query($con, $sql_del);	
		mysqli_query($con, $sql_del_dom);		
	}

	if(isset($_POST['func'])) {
		$postFunction = $_POST['func'];
		if($postFunction == "save") {
			$user_id = $_POST['user_id'];
			$dom_id = $_POST['dom_id'];
			$record_id = $_POST['record_id'];
			$name = $_POST['name'];
			$type = $_POST['type'];
			$value = $_POST['value'];
			$prio = $_POST['prio'];
			$ttl = $_POST['ttl'];
			save_record_values($user_id,$dom_id,$record_id,$name,$type,$value,$prio,$ttl);
			echo "success";
		}	
	
		if($postFunction == "insert") {
			$user_id = $_POST['user_id'];
			$dom_id = $_POST['dom_id'];
			$name = $_POST['name'];
			$type = $_POST['type'];
			$value = $_POST['value'];
			$prio = $_POST['prio'];
			$ttl = $_POST['ttl'];
			insert_record_values($user_id,$dom_id,$name,$type,$value,$prio,$ttl);
			echo "success";
		}

		if($postFunction == "del") {
			$record_id = $_POST['record_id'];
			del_record_values($record_id);
			echo "success";
		}

		if($postFunction == "add_domain") {
			$user_id = $_POST['user_id'];
			$domain = $_POST['domain'];
			add_domain($user_id,$domain);
		}

		if($postFunction == "del_domain") {
			$dom_id = $_POST['dom_id'];
			del_domain($dom_id);
			echo "success";
		}
		
		if($postFunction == "add_ticket") {
			$user_id = $_POST['user_id'];
			$domain = $_POST['domain'];
			$type = $_POST['type'];
			$title = $_POST['title'];
			$message = $_POST['message'];
			add_ticket($user_id, $domain, $type, $title, $message);
			echo "success";
		}
		
		if($postFunction == "send_comment") {
			$id = $_POST['id'];
			$user_id = $_POST['user_id'];
			$comment = $_POST['comment'];
			$status = $_POST['status'];
			send_comment($id, $status, $comment, $user_id);
			echo "success";
		}
	}	

	function get_domains($user_id, $site) {
		include('config/config.php');
		$sql = "SELECT * FROM domains AS d INNER JOIN user_domains AS ud ON ud.domain_id=d.id INNER JOIN users AS u ON u.id='$user_id' AND ud.user_id='$user_id'";
		$result = mysqli_query($con, $sql);
		while($obj = mysqli_fetch_array($result))  
		{
			if($site != "ticket") {
				echo '<li class="navdom"><a href="dns.php?domainid='.$obj["domain_id"].'">'.$obj["name"].'</a></li>';
			} else {
				echo '<option>'.$obj["name"].'</option>';
			}
		}
	}

	function get_ticket_num($status, $user_id) {
		include('config/config.php');
		if($status == "open") {
			$status = ">";
		} else {
			$status = "=";
		}
		$sql ="SELECT id FROM tickets WHERE is_active $status 0 AND user_id='$user_id'";
		//echo $sql = "SELECT * FROM records AS r INNER JOIN (users AS u INNER JOIN user_domains AS ud ON u.id=ud.user_id) INNER JOIN domain_records AS dr ON r.id=dr.records_id WHERE u.id='$user_id' AND dr.domain_id='$dom_id' AND r.domain_id='$dom_id'";
		$result = mysqli_query($con, $sql);
		$rows = mysqli_num_rows($result);
		return $rows;	
	}

	function get_tickets($sort, $status, $user_id) {
		include('config/config.php');
		if($status == "open") {
			$status = ">";
		} else {
			$status = "=";
		}
		if($sort == 1) {
			$sql ="SELECT t.id, t.title, t.created_at, t.message, t.user_id, u.email, u.username FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE is_active $status 0 AND user_id='$user_id' ORDER BY t.id ASC";
		} else if($sort == 2) {
			$sql ="SELECT t.id, t.title, t.created_at, t.message, t.user_id, u.email, u.username FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE is_active $status 0 AND user_id='$user_id' ORDER BY t.id DESC";
		} else{
			$sql ="SELECT t.id, t.title, t.created_at, t.message, t.user_id, u.email, u.username FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id WHERE is_active $status 0 AND user_id='$user_id'";
		}
		//echo $sql = "SELECT * FROM records AS r INNER JOIN (users AS u INNER JOIN user_domains AS ud ON u.id=ud.user_id) INNER JOIN domain_records AS dr ON r.id=dr.records_id WHERE u.id='$user_id' AND dr.domain_id='$dom_id' AND r.domain_id='$dom_id'";
		$result = mysqli_query($con, $sql);
		//$num = mysqli_num_rows($result);
		//$tickets = mysqli_fetch_array($result);
		while($obj = mysqli_fetch_array($result)) 
		{
			echo '<li style="width: 100%;"><p style="width: 50px; color: #000;">'.$obj["id"].'</p>';
			echo '<p style="width: 454px;color: #000;"><a href="show_ticket.php?id='.$obj["id"].'">'.$obj["title"].'</a></p>';
			echo '<p style="width: 100px;color: #000;">'.$obj["username"].'</p>';
			echo '<p style="width: 260px;color: #000;">'.$obj["created_at"].'</p></li>';
		}	
	}
	
	function get_ticket_details($id, $user_id) {
		include('config/config.php');
		$sql ="SELECT t.title, t.created_at, u.username, t.domain, t.categorie FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id AND t.user_id='$user_id' WHERE t.id='$id'";
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

	function get_ticket_message($id, $user_id) {
		include('config/config.php');
		$sql ="SELECT u.username, t.message, t.created_at FROM tickets AS t INNER JOIN users AS u ON t.user_id=u.id AND t.user_id='$user_id' WHERE t.id='$id'";
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

	function get_comments($id, $user_id) {
		include('config/config.php');
		$sql ="SELECT c.comment, c.created_at, u.username, u.role FROM comments AS c INNER JOIN users AS u ON c.user_id=u.id INNER JOIN tickets AS t ON t.id=ticket_id AND t.user_id='$user_id' WHERE t.id='$id'";
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
		include('config/config.php');
		if($status == "true") {
			$sql_update = "UPDATE tickets SET is_active=0 WHERE id='$id'";
			mysqli_query($con, $sql_update);
		}
		if(date('I')) {
			$datum = date('Y-m-d H:i:s');
		} else {
			$time1 = time() - 3600;
			$datum = date('Y-m-d H:i:s', $time1);
		}
		$sql = "INSERT INTO comments (ticket_id, user_id, comment, created_at) VALUES ('$id','$user_id','$comment','$datum')";
		mysqli_query($con, $sql);
	}
?>