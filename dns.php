<?php
	include_once "tpl/header.php";
	include_once "functions.php";
	$dom_id=$_GET["domainid"];
?>
			<div id="content">
				<h2></h2>
				<ul class="record_header">
					<li class="r_name"><p>Name</p></li>
					<li class="r_type"><p>Typ</p></li>
					<li class="r_value"><p>Wert</p></li>
					<li class="r_prio"><p>Prio</p></li>
					<li class="r_ttl"><p>TTL</p></li>
					<li class="save"></li>
				</ul>
				<div id="records">
					<?php get_record_values($user_id,$dom_id); ?>
				</div>
				<button style="margin-top: 10px; float: left;" onclick="del_domain(this)">Domain l&ouml;schen</button>
				<button style="margin-top: 10px; float: right;" onclick="add()">Record hinzuf&uuml;gen</button>
<?php
	include_once "tpl/footer.php";
?>