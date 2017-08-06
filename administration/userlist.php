<?php
	include_once "tpl/header.php";
	//include_once "functions.php";
?>
</div>
<div class="container">
<div id="content">
	<div style="width: 100%; background-color: #9595A2; height: 35px; color: #fff; margin-top: 20px;"><p style="margin-left: 10px;">Administration</p></div>
		<?php get_user_list(); ?>
</div>
<script>
function toggle(key){
        var div = document.getElementById(key);
	if (div.style.display =='block'){
                div.style.display = 'none';
        	return;
        }
	div.style.display ='block';
}

		function save_user(sender){
			var ulElement = sender.parentNode.parentNode;
			var user_id = ulElement.getElementsByClassName("user_id");
			var vorname = ulElement.getElementsByClassName("vorname");
			var nachname = ulElement.getElementsByClassName("nachname");
			var email = ulElement.getElementsByClassName("email");
			var typeIndex = ulElement.getElementsByClassName("role")[0].selectedIndex;
			var type = ulElement.getElementsByClassName("role")[0].options;
			$.post("functions.php",
    			{
				func: "save_user",
				user_id: user_id[0].innerHTML,
				vorname: vorname[0].value,
				nachname: nachname[0].value,
				email: email[0].value,
				role: role[typeIndex].text
    			},
    			function(status){
				if(status == "success") {
        				ulElement.getElementsByTagName("button")[0].innerHTML = "Gespeichert";
				} else {
					ulElement.getElementsByTagName("button")[0].innerHTML = "Fehler";
				}
    			});	
		}
</script>
<?php
	include_once "tpl/footer.php";
?>