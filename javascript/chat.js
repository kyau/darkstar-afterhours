/* pagbuild.js */

var chatPath = 'https://' + location.host + '/getchat.php';

function toFixed(value, precision) {
	var power = Math.pow(10, precision || 0);
	return String(Math.round(value * power) / power);
}

function loadChat() {
	$("#chat").delay(1000).slideDown("slow");
	buildChatTable();
	setInterval("buildChatTable()", 5000);
}

function buildChatTable() {
	$.getJSON(chatPath, function (jsonData) {
		var html = "";
		
		if (jQuery.isEmptyObject(jsonData)) {
			return 0;
		} else {
			//console.log("Running getchat.php!");
			$.each(jsonData, function(i, chatline) {
				if (chatline.name == null)
					return true;
				if (chatline.name == "AfterHours")
					html += "<div class=\"say\"><span class=\"chat-time\">["+chatline.timestamp+"]</span> <span class=\"servermsg\">" + chatline.message + "</span></div>";
				else
					html += "<div class=\"say\"><span class=\"chat-time\">["+chatline.timestamp+"]</span> <a href=\"/char/"+chatline.charid+"\">"+chatline.name+"</a> : " + chatline.message + "</div>";
			});
			$("#chat").html(html);
		}
	});
}
