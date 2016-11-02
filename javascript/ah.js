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

function loadStartPage() {}

function getAHCategory() {
	var ahcat = $("body").data("id");
	$.ajax({
		url: "/getah.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		data: { id : ahcat },
		success: function(jsonData) {
			if (jsonData.category == null) {
				return 0;
			} else {
				$("#auctions").html("");
				if (ahcat > 13 && ahcat != 15) {
					//$(".tbl-ahcat").find(".tbl-subhead").find("td:eq(2)").remove();
					//console.log("Removing DPS Header!");
					$(".tbl-ahcat thead tr.tbl-subhead th:eq(2)").remove();
				}
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
					if (ahcat < 14 || ahcat == 15)
						html += "<td class=\"center\">"+item.dps+"</td>";
					html += "<td class=\"center\">"+item.price+"</td>";
					html += "<td class=\"center\">"+item.instock+"</td>";
					html += "</tr>";
					$("#auctions").append(html);
				});
				$(".tbl-ahcat").tablesorter({
					headers: {
						4: {
							sorter: 'price'
						}
					}
				});
			}
		}
	});
}

$(function() {
	getAHCategory();

	$(".tbl-subhead th").mouseup(function() {
		$(".tablesorter-header .fa").each(function() {
			$(this).attr('class', 'fa').addClass('fa-sort');
		});
		if ($(this).hasClass("tablesorter-headerUnSorted")) {
			$(this).find(".tablesorter-header-inner .fa").attr('class', 'fa').addClass('fa-sort-desc');
		} else if ($(this).hasClass("tablesorter-headerAsc")) {
			$(this).find(".tablesorter-header-inner .fa").attr('class', 'fa').addClass('fa-sort-asc');
		} else if ($(this).hasClass("tablesorter-headerDesc")) {
			$(this).find(".tablesorter-header-inner .fa").attr('class', 'fa').addClass('fa-sort-desc');
		}
	});
});