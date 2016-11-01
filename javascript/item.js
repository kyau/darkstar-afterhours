/* pagbuild.js */

var gpdPath = 'https://' + location.host + '/getitem.php';

function toFixed(value, precision) {
	var power = Math.pow(10, precision || 0);
	return String(Math.round(value * power) / power);
}

function loadStartPage() {
	buildPlayerTable();
	setInterval("buildPlayerTable()", 30000);
}

function buildPlayerTable() {
	var itemid = $("body").data("id");
	var stack = $("body").data("stack");
	$.getJSON(gpdPath + '?id=' + itemid + '&stack=' + stack, function (jsonData) {
		if (jQuery.isEmptyObject(jsonData)) {
			return 0;
		} else {
			//console.log("Running getchar.php!");
			$(document).prop('title', 'AfterHours - ' + jsonData.realname);
			$(".i_item").html(jsonData.realname);
			$(".i_mainicon").attr("src", "images/large-icons/" + jsonData.itemid + ".png");
			if (jsonData.ex == true && jsonData.rare == true) {
				$(".i_raex").html('<img src="images/icons/g_rare.png" class="i_rare"><img src="images/icons/g_exclusive.png" class="i_ex">');
			} else if (jsonData.ex == true) {
				$(".i_raex").html('<img src="images/icons/g_exclusive.png" class="i_ex">');
			} else if (jsonData.rare == true) {
				$(".i_raex").html('<img src="images/icons/g_rare.png" class="i_rare">');
			}
			if (jsonData.armor == 1) {
				$(".i_jobs").html("Lv"+jsonData.level+" &nbsp; "+jsonData.jobs);
				$(".i_stats").html(jsonData.mods);
			} else {
				$(".i_jobs").html("");
				$(".i_stats").html(jsonData.description);
			}
			/*
			$("#auto_img").attr("src", jsonData.char_img);
			$("#auto_zone").html(jsonData.zone);
			*/
			$(".item-bgwiki").html("<a href=\"//www.bg-wiki.com/bg/"+jsonData.sortname+"\"><img style=\"vertical-align:text-bottom\" src=\"images/bgwiki.png\"></a>");
			if (jsonData.nosale == 0) {
				$(".item-stock").html(jsonData.instock);
				$(".item-currprice").html(jsonData.price);
				$(".item-ahcat").html("<a class=\"catlink\" data-id=\""+jsonData.ahcatid+"\">"+jsonData.ahcat+"</a>");
				$("#auctions").html("");
				var z = 0;
				$.each(jsonData.ah, function(i, item) {
					var html = "";
					html += "<tr>";
					html += "<td class=\"ah-date\">"+item.date+"</td>";
					html += "<td class=\"ah-who\">"+item.seller+"</td>";
					html += "<td class=\"ah-who\">"+item.buyer+"</td>";
					html += "<td class=\"ah-price\">"+item.price+"</td>";
					html += "</tr>";
					$("#auctions").append(html);
					z = z + 1;
				});
				if (z != 0)
					$("#price_history").html(" ("+z+")");
			} else {
				$(".tbl.tbl-ahcathead").css("display", "none");
				$(".tbl-ah").css("display", "none");
				var $rows = $(".tbl-stats tr");
				$rows.eq(1).hide();
				$rows.eq(2).hide();
			}
		}
	});
}
