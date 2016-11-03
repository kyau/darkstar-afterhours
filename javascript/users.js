function loadStartPage() {}

function getAllUsers() {
	$.ajax({
		url: "../getusers.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		success: function(jsonData) {
			var allUsers = '';
			if (jQuery.isEmptyObject(jsonData)) {
				allUsers = '<br/><br/><h3>No users on server yet!</h3>';
			} else {
				$.each(jsonData.users, function(i, userData) {
					allUsers += '<tr><td>';
					if (userData.online == 1)
						allUsers += '<i style="color:rgba(0,180,0,1)" class="fa fa-check" aria-hidden="true"></i>';
					else
						allUsers += '<i style="color:rgba(180,0,0,1)" class="fa fa-times" aria-hidden="true"></i>';
					allUsers += '</td><td>';
					allUsers += '<a href="/char/' + userData.charid + '">';
					if (parseInt(userData.nation) == 0)
						allUsers += '<img class="nation" src="images/sandoria.png" /> ';
					else if (parseInt(userData.nation) == 1)
						allUsers += '<img class="nation" src="images/bastok.png" /> ';
					else
						allUsers += '<img class="nation" src="images/windurst.png" /> ';
					allUsers += userData.name + '</a></td>';
					allUsers += '  <td>' + '<a href="/char/' + userData.charid + '">' + userData.zone.replace(/_/g," ") + '</a></td>' +
								  '  <td>' + '<a href="/char/' + userData.charid + '">' + userData.mainjob;
					if (userData.subjob.substr(0,6) != "GENKAI") {
						allUsers += '/';
						allUsers += userData.subjob + '</a></td></tr>';
					}
				});
			}
			$('#ajax').html(allUsers);
			$("#tbl-allusers").trigger("update");
		}
	})
}

$(function() {
	$("#tbl-allusers").tablesorter();
	getAllUsers();
	setInterval("getAllUsers()", 30000);
});