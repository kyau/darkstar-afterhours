/* pagbuild.js */

var gpdPath = 'https://' + location.host + '/getonline.php';
var	lastSortList = [[0,0]];

function loadStartPage() {
	$("#tbl-online").tablesorter();
	buildPlayerTable();
	setInterval("buildPlayerTable()", 5000);
}

function buildPlayerTable() {
	$.getJSON(gpdPath, function (jsonData) {
		var html;
		if (jQuery.isEmptyObject(jsonData)) {
      html = '<br/><br/><h3>No users currently logged in!</h3>';
		} else {
			var playerRows = '';
			$.each(jsonData.users, function(i, userData) {
				playerRows += '<tr><td>';
				playerRows += '<a href="/char/' + userData.charid + '">';
				if (parseInt(userData.nation) == 0)
					playerRows += '<img class="nation" src="images/sandoria.png" /> ';
			  else if (parseInt(userData.nation) == 1)
					playerRows += '<img class="nation" src="images/bastok.png" /> ';
				else
					playerRows += '<img class="nation" src="images/windurst.png" /> ';
        playerRows += userData.name + '</a></td>';
  			playerRows += '  <td>' + '<a href="/char/' + userData.charid + '">' + userData.zone.replace(/_/g," ") + '</a></td>' +
					      			'  <td>' + '<a href="/char/' + userData.charid + '">' + userData.mainjob;
				if (userData.subjob != "") playerRows += '/';
					playerRows += userData.subjob + '</a></td>' +
					      				'</tr>';
			});
			html = '<table class="tbl tbl-hover" id="online">' +
					'  <thead><tr class="tbl-head">' +
					'    <th>Player <i class="fa fa-unsorted" aria-hidden="true"></i></th>' +
					'    <th>Area <i class="fa fa-unsorted" aria-hidden="true"></i></th>' +
					'    <th>Job <i class="fa fa-unsorted" aria-hidden="true"></i></th>' +
					'  </tr></thead><tbody>' +
					playerRows +
					'</tbody><table>';
		}
		$('#online').html(playerRows);
		$("#tbl-online").trigger("update");
	});
}
