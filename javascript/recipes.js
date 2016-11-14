function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function loadStartPage() {}

function getRecipeCategory() {
	var craftranks = ["Amateur", "Recruit", "Initiate", "Novice", "Apprentice", "Journeyman", "Craftsman", "Artisan", "Adept", "Veteran", "Expert", "Authority"];
	var craftranksLength = craftranks.length;
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
				// populate recipe header
				var headerhtml = "<tr>";
				for (var i = 0; i < craftranksLength; i++) {
					if ((i+1) == rank) {
						headerhtml += "<td class=\"center\">"+craftranks[i]+"</td>";
					} else {
						headerhtml += "<td class=\"center\"><a class=\"blue\" href=\"/recipes/"+craft+"/"+(i+1)+"\">"+craftranks[i]+"</a></td>";
					}
					if (i == 5)
						headerhtml += "</tr><tr>";
				}
				headerhtml += "</tr>";
				$(".recipes-header").html(headerhtml);
				// populate recipes
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
					crystalclass = item[1].split(" ")[0].toLowerCase();
					html += "<tr>";
					html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
					html += "<td class=\"left\"><a class=\""+crystalclass+" tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a></td>";
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
					html += "<tr><td colspan=\"3\" class=\"left lightgray\">Total Cost: "+numberWithCommas(recipe.ingredientcost);
					html += "</tbody></table>"
					html += "</td>";
					// Results
					html += "<td class=\"left vtop\">"
					html += "<table class=\"tbl-items\"><tbody>";
					item = recipe.result.split(":");
					profithtml = "";
					if (recipe.resultcount > 1) {
						single = (recipe.pricestack / recipe.stacksize);
						profit = Math.round((single * recipe.resultcount) - recipe.ingredientcost);
					} else {
						profit = Math.round(recipe.price - recipe.ingredientcost);
					}

					if (profit < 0)
						profithtml += " <span class=\"red\">("+numberWithCommas(Math.abs(profit))+")</span>";
					else
						profithtml += " <span class=\"green\">+"+numberWithCommas(profit)+"</span>";
					html += "<tr>";
					html += "<td>NQ: </td>";
					html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
					html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
					html += " <span class=\"lightgray\">x"+recipe.resultcount+"</span>"+profithtml+"</td>";
					html += "</tr>";
					if ((recipe.resulthq1 != recipe.result || recipe.resulthq1count != recipe.resultcount)) {
						item = recipe.resulthq1.split(":");
						profithtml = "";
						//profithq1 = recipe.pricehq1 - recipe.ingredientcost;
						if (recipe.resulthq1count > 1) {
							single = (recipe.pricestack / recipe.stacksize);
							profithq1 = Math.round((single * recipe.resulthq1count) - recipe.ingredientcost);
						} else {
							profithq1 = Math.round(recipe.pricehq1 - recipe.ingredientcost);
						}
						if (profithq1 < 0)
							profithtml += " <span class=\"red\">("+numberWithCommas(Math.abs(profithq1))+")</span>";
						else
							profithtml += " <span class=\"green\">+"+numberWithCommas(profithq1)+"</span>";
						html += "<tr>";
						html += "<td>HQ1: </td>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+recipe.resulthq1count+"</span>"+profithtml+"</td>";
						html += "</tr>";
					}
					if ((recipe.resulthq2 != recipe.result || recipe.resulthq2count != recipe.resultcount) && (recipe.resulthq2 != recipe.resulthq1 || recipe.resulthq2count != recipe.resulthq1count)) {
						item = recipe.resulthq2.split(":");
						profithtml = "";
						//profithq2 = recipe.pricehq2 - recipe.ingredientcost;
						if (recipe.resulthq2count > 1) {
							single = (recipe.pricestack / recipe.stacksize);
							profithq2 = Math.round((single * recipe.resulthq2count) - recipe.ingredientcost);
						} else {
							profithq2 = Math.round(recipe.pricehq2 - recipe.ingredientcost);
						}
						if (profithq2 < 0)
							profithtml += " <span class=\"red\">("+numberWithCommas(Math.abs(profithq2))+")</span>";
						else
							profithtml += " <span class=\"green\">+"+numberWithCommas(profithq2)+"</span>";
						html += "<tr>";
						html += "<td>HQ2: </td>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+recipe.resulthq2count+"</span>"+profithtml+"</td>";
						html += "</tr>";
					}
					if ((recipe.resulthq3 != recipe.result || recipe.resulthq3count != recipe.resultcount) && (recipe.resulthq3 != recipe.resulthq1 || recipe.resulthq3count != recipe.resulthq1count) && (recipe.resulthq3 != recipe.resulthq2 || recipe.resulthq3count != recipe.resulthq2count)) {
						item = recipe.resulthq3.split(":");
						profithtml = "";
						//profithq3 = recipe.pricehq3 - recipe.ingredientcost;
						if (recipe.resulthq3count > 1) {
							single = (recipe.pricestack / recipe.stacksize);
							profithq3 = Math.round((single * recipe.resulthq3count) - recipe.ingredientcost);
						} else {
							profithq3 = Math.round(recipe.pricehq3 - recipe.ingredientcost);
						}
						if (profithq3 < 0)
							profithtml += " <span class=\"red\">("+numberWithCommas(Math.abs(profithq3))+")</span>";
						else
							profithtml += " <span class=\"green\">+"+numberWithCommas(profithq3)+"</span>";
						html += "<tr>";
						html += "<td>HQ3: </td>";
						html += "<td class=\"icon\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item[0]+".png\" /></a></td>";
						html += "<td class=\"left\"><a class=\"tip\" data-id=\""+item[0]+"\" data-stack=\"1\" href=\"/item/"+item[0]+"\">"+item[1]+"</a>";
						html += " <span class=\"lightgray\">x"+recipe.resulthq3count+"</span>"+profithtml+"</td>";
						html += "</tr>";
					}
					html += "</tbody></table>"
					html += "</td>";
					html += "</tr>";
/*
					html += "<tr><td colspan=\"3\" class=\"center\">Total Cost: "+numberWithCommas(recipe.ingredientcost)+" &mdash; NQ: ";
					profit = recipe.ingredientcost - recipe.price;
					if (profit < 0)
						html += "<span class=\"red\">"+numberWithCommas(profit)+"</span>";
					else
						html += "<span class=\"green\">"+numberWithCommas(profit)+"</span>";
					if (recipe.pricehq1 != 0) {
						profithq1 = recipe.ingredientcost - recipe.pricehq1;
						if (profithq1 < 0)
							html += " &mdash; HQ1: <span class=\"red\">"+numberWithCommas(profithq1)+"</span>";
						else
							html += " &mdash; HQ1: <span class=\"green\">"+numberWithCommas(profithq1)+"</span>";
					}
					if (recipe.pricehq2 != 0) {
						profithq2 = recipe.ingredientcost - recipe.pricehq2;
						if (profithq2 < 0)
							html += " &mdash; HQ2: <span class=\"red\">"+numberWithCommas(profithq2)+"</span>";
						else
							html += " &mdash; HQ2: <span class=\"green\">"+numberWithCommas(profithq2)+"</span>";
					}
					if (recipe.pricehq3 != 0) {
						profithq3 = recipe.ingredientcost - recipe.pricehq3;
						if (profithq3 < 0)
							html += " &mdash; HQ3: <span class=\"red\">"+numberWithCommas(profithq3)+"</span>";
						else
							html += " &mdash; HQ3: <span class=\"green\">"+numberWithCommas(profithq3)+"</span>";
					}
					html += "</td></tr>";
*/
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