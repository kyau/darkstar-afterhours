function loadStartPage() {}

function getRecipeCategory() {
	var craft = $("body").data("id");
	var rank = $("body").data("stack");
	$.ajax({
		url: "/getrecipes.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		data: { cat : craft, rank : rank },
		success: function(jsonData) {
			if (jsonData.category == null) {
				return 0;
			} else {
				$("#recipes").html("");
				$(document).prop('title', 'AfterHours - ' + jsonData.category);
				$.each(jsonData.recipes, function(i, recipe) {
					var html = "";
					html += "<tr>";
					html += "<td class=\"center vtop\">";
					//html += "id:"+recipe.id+"<br/>";
					if (recipe.alchemy != 0)
						html += "Alchemy (" + recipe.alchemy + ")<br/>";
					if (recipe.bone != 0)
						html += "Bonecraft (" + recipe.bone + ")<br/>";
					if (recipe.cloth != 0)
						html += "Clothcraft (" + recipe.cloth + ")<br/>";
					if (recipe.cook != 0)
						html += "Cooking (" + recipe.cook + ")<br/>";
					if (recipe.gold != 0)
						html += "Goldsmithing (" + recipe.gold + ")<br/>";
					if (recipe.leather != 0)
						html += "Leathercraft (" + recipe.leather + ")<br/>";
					if (recipe.smith != 0)
						html += "Smithing (" + recipe.smith + ")<br/>";
					if (recipe.wood != 0)
						html += "Woodworking (" + recipe.wood + ")<br/>";
					html += "</td>";
					// Ingredients
					html += "<td class=\"left vtop\">"
					html += "<table class=\"tbl-items\"><tbody>";
					item = recipe.crystal.split(":");
					html += "<tr>";
					html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
					html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a></td>";
					html += "</tr>";
					$.each(recipe.ingredients, function(i, ingredient) {
						//console.log(i);
						item = i.split(":");
						html += "<tr>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+ingredient+"</span></td>";
						html += "</tr>";
					});
					html += "</tbody></table>"
					html += "</td>";
					// Results
					html += "<td class=\"left vtop\">"
					html += "<table class=\"tbl-items\"><tbody>";
					item = recipe.result.split(":");
					html += "<tr>";
					html += "<td>NQ: </td>";
					html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
					html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
					html += " <span class=\"lightgray\">x"+recipe.resultcount+"</span></td>";
					html += "</tr>";
					if ((recipe.resulthq1 != recipe.result || recipe.resulthq1count != recipe.resultcount)) {
						item = recipe.resulthq1.split(":");
						html += "<tr>";
						html += "<td>HQ1: </td>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+recipe.resulthq1count+"</span></td>";
						html += "</tr>";
					}
					if ((recipe.resulthq2 != recipe.result || recipe.resulthq2count != recipe.resultcount) && (recipe.resulthq2 != recipe.resulthq1 || recipe.resulthq2count != recipe.resulthq1count)) {
						item = recipe.resulthq2.split(":");
						html += "<tr>";
						html += "<td>HQ2: </td>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+recipe.resulthq2count+"</span></td>";
						html += "</tr>";
					}
					if ((recipe.resulthq3 != recipe.result || recipe.resulthq3count != recipe.resultcount) && (recipe.resulthq3 != recipe.resulthq1 || recipe.resulthq3count != recipe.resulthq1count) && (recipe.resulthq3 != recipe.resulthq2 || recipe.resulthq3count != recipe.resulthq2count)) {
						item = recipe.resulthq3.split(":");
						html += "<tr>";
						html += "<td>HQ3: </td>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+recipe.resulthq3count+"</span></td>";
						html += "</tr>";
					}
					html += "</tbody></table>"
					html += "</td>";
					html += "</tr>";
					$("#recipes").append(html);
				});
				$(".tbl-recipes").tablesorter();
			}
		}
	});
}

$(function() {
	getRecipeCategory();

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