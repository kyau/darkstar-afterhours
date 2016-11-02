function loadStartPage() {}
/*function loadStartPage() {
	$("#tbl-online").tablesorter();
	buildPlayerTable();
	setInterval("buildPlayerTable()", 5000);
}*/

function getOnlinePlayers() {
	$.ajax({
		url: "/getonline.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		success: function(jsonData) {
			var onlineUsers = '';
			if (jsonData.users == null) {
				onlineUsers = '<tr><td colspan="3"><span class="center">No users currently logged in!</span></td></tr>';
			} else {
				$.each(jsonData.users, function(i, userData) {
					onlineUsers += '<tr><td>';
					onlineUsers += '<a href="/char/' + userData.charid + '">';
					if (parseInt(userData.nation) == 0)
						onlineUsers += '<img class="nation" src="images/sandoria.png" /> ';
					else if (parseInt(userData.nation) == 1)
						onlineUsers += '<img class="nation" src="images/bastok.png" /> ';
					else
						onlineUsers += '<img class="nation" src="images/windurst.png" /> ';
					onlineUsers += userData.name + '</a></td>';
					onlineUsers += '  <td>' + '<a href="/char/' + userData.charid + '">' + userData.zone.replace(/_/g," ") + '</a></td>' +
								  '  <td>' + '<a href="/char/' + userData.charid + '">' + userData.mainjob;
					if (userData.subjob != "") onlineUsers += '/';
						onlineUsers += userData.subjob + '</a></td></tr>';
				});
			}
			$('#ajax').html(onlineUsers);
			$("#tbl-online").trigger("update");
		}
	});
}

$(function() {
	$("#ajax").tablesorter();
	getOnlinePlayers();
	setInterval("getOnlinePlayers()", 5000);
});