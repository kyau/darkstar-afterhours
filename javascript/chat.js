function loadChat() {}

function getGlobalChat() {
	$.ajax({
		url: '/getchat.php',
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		success: function(jsonData) {
			var chatlog = '';
			if (jsonData == null) {
				console.log("killing");
				return 0;
			} else {
				$.each(jsonData, function(i, chatline) {
					if (chatline.name == null)
						return true;
					else if (chatline.name == "AfterHours")
						chatlog += "<div class=\"say\"><span class=\"chat-time\">["+chatline.timestamp+"]</span> <span class=\"servermsg\">" + chatline.message + "</span></div>";
					else
						chatlog += "<div class=\"say\"><span class=\"chat-time\">["+chatline.timestamp+"]</span> <a href=\"/char/"+chatline.charid+"\">"+chatline.name+"</a> : " + chatline.message + "</div>";
				});
				$("#chat").html(chatlog);
			}
		}
	});
}

$(function() {
	$("#chat").delay(1000).slideDown("slow");
	getGlobalChat();
	setInterval("getGlobalChat()", 5000);
});