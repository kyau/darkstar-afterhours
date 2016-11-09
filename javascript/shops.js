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

function getShopCategory() {
	var shopcat = $("body").data("id");
	$.ajax({
		url: "/getshop.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		data: { id : shopcat },
		success: function(jsonData) {
			if (jsonData.category == null) {
				return 0;
			} else {
				$("#auctions").html("");
				$.each(jsonData.items, function(i, item) {
					var category = $("#shopcat").text();
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
		}
	});
}

$(function() {
	getShopCategory();

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