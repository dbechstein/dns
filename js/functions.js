
		function save(sender){
			var ulElement = sender.parentNode.parentNode;
			var user_id = ulElement.getElementsByClassName("user_id");
			var dom_id = ulElement.getElementsByClassName("dom_id");
			var record_id = ulElement.getElementsByClassName("record_id");
	    		var name = ulElement.getElementsByClassName("record_name");
			var typeIndex = ulElement.getElementsByClassName("recordss")[0].selectedIndex;
			var type = ulElement.getElementsByClassName("recordss")[0].options;
			var value = ulElement.getElementsByClassName("record_value");
    			var prio = ulElement.getElementsByClassName("record_prio");
    			var ttl = ulElement.getElementsByClassName("record_ttl");
			$.post("functions.php",
    			{
					func: "save",
					user_id: user_id[0].value,
					dom_id: dom_id[0].value,
					record_id: record_id[0].value,
					name: name[0].value,
			    	type: type[typeIndex].text,
					value: value[0].value,
					prio: prio[0].value,
					ttl: ttl[0].value
    			},
    			function(status){
				if(status == "success") {
        			ulElement.getElementsByTagName("button")[0].innerHTML = "Gespeichert";
				} else {
					ulElement.getElementsByTagName("button")[0].innerHTML = "Fehler";
				}
    		});	
		}

		function insert(sender_insert){
			var ulElement = sender_insert.parentNode.parentNode;
			var user_id = ulElement.getElementsByClassName("user_id");
			var dom_id = ulElement.getElementsByClassName("dom_id");
    		var name = ulElement.getElementsByClassName("record_name");
			var typeIndex = ulElement.getElementsByClassName("recordss")[0].selectedIndex;
			var type = ulElement.getElementsByClassName("recordss")[0].options;
			var value = ulElement.getElementsByClassName("record_value");
    		var prio = ulElement.getElementsByClassName("record_prio");
    		var ttl = ulElement.getElementsByClassName("record_ttl");
			$.post("functions.php", {
				func: "insert",
				user_id: user_id[0].value,
				dom_id: dom_id[0].value,
				name: name[0].value,
				type: type[typeIndex].text,
				value: value[0].value,
				prio: prio[0].value,
				ttl: ttl[0].value
    		},
    		function(status){
				if(status == "success") {
        			ulElement.getElementsByTagName("button")[0].innerHTML = "Gespeichert";
				} else {
					ulElement.getElementsByTagName("button")[0].innerHTML = "Fehler";
				}
				
    		});	
		}

		function del(sender_del){
			var ulElement = sender_del.parentNode.parentNode;
			var record_id = ulElement.getElementsByClassName("record_id");
			$.post("functions.php", {
				func: "del",
				record_id: record_id[0].value
    		},
			function(status){
				if(status == "success") {
        			ulElement.style.display ="none";
				} else {
					ulElement.getElementsByTagName("button")[0].innerHTML = "Fehler";
				}
    		});	
		}

		function add_domain(sender_add_domain){
			var ulElement = sender_add_domain.parentNode.parentNode;
			var domain = ulElement.getElementsByClassName("domain");
			var user_id = ulElement.getElementsByClassName("user_id");
			$.post("functions.php", {
				func: "add_domain",
				user_id: user_id[0].value,
				domain: domain[0].value
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

		function del_domain(sender_del_domain){
			var ulElement = sender_del_domain.parentNode.parentNode;
			var dom_id = ulElement.getElementsByClassName("dom_id");
			$.post("functions.php", {
				func: "del_domain",
				dom_id: dom_id[0].value
    		}, 
    		function(status){
				if(status == "success") {
        			alert("Domain geloescht!");
				} else {
					alert("Fehler!");
				}
    		});	
		}

		function add() {
            tableRows = document.getElementById("records").getElementsByTagName("ul");
            var rows = tableRows.length;
			var div = document.getElementById("records");
			var user_id = document.getElementsByClassName("user_id");
			var dom_id = document.getElementsByClassName("dom_id");
			var func = "insert";
			div.innerHTML = div.innerHTML + '<ul id="record_' + (rows+1) + '" class="record_content"><li><input class="user_id" type="hidden" value="' + user_id[0].value + '"><input class="dom_id" type="hidden" value="' + dom_id[0].value + '"><input class="record_name" type="text" id="username" value="" maxlength="30"></li><li><select class="recordss"><option id="Select">Please Select</option><option id="record_A">A</option><option id="record_AAAA">AAAA</option><option id="record_CNAME">CNAME</option><option id="record_MX">MX</option><option id="record_txt">TXT</option></select></li><li><input class="record_value" type="text" id="username" value="" maxlength="30"></li><li><input class="record_prio" type="text" id="username" value="" maxlength="30"></li><li><input class="record_ttl" type="text" id="username" value="" maxlength="30"></li><li><button onclick="insert(this)">Speichern</button></li></ul>\r\n';
		}
		
		
		function addTicket(sender_add_ticket) {
			var ulElement = sender_add_ticket.parentNode.parentNode;
			var domainIndex = ulElement.getElementsByClassName("domain")[0].selectedIndex;
			var domaintype = ulElement.getElementsByClassName("domain")[0].options;
			var typeIndex = ulElement.getElementsByClassName("type")[0].selectedIndex;
			var type = ulElement.getElementsByClassName("type")[0].options;
			var title = ulElement.getElementsByClassName("betreff");
			var message = ulElement.getElementsByClassName("message");
			var user_id = ulElement.getElementsByClassName("user_id");
			$.post("functions.php", {
				func: "add_ticket",
				user_id: user_id[0].value,
				domain: domaintype[domainIndex].text,
				type: type[typeIndex].text,
				title: title[0].value,
				message: message[0].value
    			},
    			function(status){
					if(status == "success") {
						//window.location.href = "tickets.php?sort=0&status=open";
					} else if(status == "error") {
						alert("Fehler");
					}
				}
			);
			//alert("test");
		}