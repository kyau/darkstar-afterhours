/* pagbuild.js */

var gpdPath = 'https://' + location.host + '/getusers.php';

function loadStartPage() {
	buildPlayerTable();
	setInterval("buildPlayerTable()", 5000);
}

function buildPlayerTable() {
	$.getJSON(gpdPath, function (jsonData) {
		var html;
		if (jQuery.isEmptyObject(jsonData)) {
      html = '<br/><br/><h3>No users on server yet!</h3>';
		} else {
			var playerRows = '';
			$.each(jsonData.users, function(i, userData) {
				console.log(userData.name);
				playerRows += '<tr><td>';
				if (userData.online == 1)
					playerRows += '<i style="color:rgba(0,180,0,1)" class="fa fa-check" aria-hidden="true"></i>';
				else
					playerRows += '<i style="color:rgba(180,0,0,1)" class="fa fa-times" aria-hidden="true"></i>';
				playerRows += '</td><td>';
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
					'    <th>&nbsp</th>' +
					'    <th>Player</th>' +
					'    <th>Area</th>' +
					'    <th>Job</th>' +
					'  </tr></thead><tbody>' +
					playerRows +
					'</tbody><table>';
		}
		$('#content').html(html);
		$(".tbl").tablesorter();
	});
}
