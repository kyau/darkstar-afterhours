/* pagbuild.js */

var gpdPath = 'https://' + location.host + '/getah.php';

$.tablesorter.addParser({ 
  id: 'price', 
  is: function(s) { 
    return false; 
  }, 
  format: function(s) { 
    return s.replace(/,/g, ''); 
  }, 
  type: 'numeric' 
});

function toFixed(value, precision) {
	var power = Math.pow(10, precision || 0);
	return String(Math.round(value * power) / power);
}

function loadStartPage() {
	buildPlayerTable();
	//setInterval("buildPlayerTable()", 30000);
}

function buildPlayerTable() {
	var itemid = $("body").data("id");
	$.getJSON(gpdPath + '?id=' + itemid, function (jsonData) {
		if (jQuery.isEmptyObject(jsonData)) {
			return 0;
		} else {
			$("#auctions").html("");
			$.each(jsonData.items, function(i, item) {
				var category = $("#ahcat").text();
				$(document).prop('title', 'AfterHours - ' + category);
				var html = "";
				var stackhtml = "";
				if (item.stack > 1)
					stackhtml = "?stack=1";
				html += "<tr>";
				html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" data-stack=\"1\" href=\"/item/"+item.itemid+stackhtml+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item.itemid+".png\" /></a></td>";
				html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item.itemid+"\" data-stack=\"1\" href=\"/item/"+item.itemid+stackhtml+"\">"+item.itemname+"</a>";
				if (item.stack > 1)
					html += " x" + item.stack;
				html += "</td>";
				html += "<td class=\"center\">"+item.level+"</td>";
				html += "<td class=\"center\">"+item.price+"</td>";
				html += "<td class=\"center\">"+item.instock+"</td>";
				html += "</tr>";
				$("#auctions").append(html);
			});
			$(".tbl-ahcat").tablesorter({
				headers: {
					3: {
						sorter: 'price'
					}
				}
			});
		}
	});
}
