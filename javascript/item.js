function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function loadStartPage() {}

function getItem() {
	var itemid = $("body").data("id");
	var stack = $("body").data("stack");
	$.ajax({
		url: "/getitem.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		data: { id : itemid, stack : stack },
		success: function(jsonData) {
			if (jsonData.itemid == null) {
				return 0;
			} else {
				var realname = "";
				if (stack) {
					realname = jsonData.realname+" x"+jsonData.stack;
					$(".i_stack").html("[<a href=\"/item/"+itemid+"\">single</a>]");
				} else {
					realname = jsonData.realname
					if (jsonData.stack > 1)
						$(".i_stack").html("[<a href=\"/item/"+itemid+"?stack=1\">stack</a>]");
				}
				$(document).prop('title', 'AfterHours - ' + realname);
				$(".i_item").html(realname);
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
					// bazaar
					z = 0;
					if (jsonData.bazaar.length > 0) {
						$("#bazaars").html("");
						$.each(jsonData.bazaar, function(i, bazaar) {
							var html = "";
							html += "<tr>";
							html += "<td class=\"left\"><a class=\"blue\" href=\"/char/"+bazaar.charid+"\">"+bazaar.charname+"</a></td>";
							html += "<td class=\"center\">"+bazaar.price+"</td>";
							if (bazaar.ahprice == 0) {
								html += "<td class=\"center\"><span class=\"lightgray\">0</span></td>";
							} else if (bazaar.ahprice < 0)
								html += "<td class=\"center\"><span class=\"red\">("+numberWithCommas(Math.abs(bazaar.ahprice))+")</span></td>";
							else
								html += "<td class=\"center\"><span class=\"green\">+"+numberWithCommas(bazaar.ahprice)+"</span></td>";
							$("#bazaars").append(html);
							z = z + 1;
						});
						if (z != 0)
							$("#bazaar_list").html(" ("+z+")");
						$(".tbl-bazaar").css("display", "inline-block");
						$(".bazaar-hide").css("display", "inline-block");
					}
					// recipe
					console.log(jsonData.recipe);
					if (jsonData.recipe != null) {
						var recipe = jsonData.recipe;
						var html = "";
						html += "<tr>";
						html += "<td class=\"center vtop\">";
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
						html += "<span class=\"lightgray\">id:"+recipe.id+"</span>";
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
						$("#recipes").html(html);
						$(".recipe-hide").css("display", "block");
					}
				} else {
					$(".tbl.tbl-ahcathead").css("display", "none");
					$(".tbl-ah").css("display", "none");
					var $rows = $(".tbl-stats tr");
					$rows.eq(1).hide();
					$rows.eq(2).hide();
				}
			}
		}
	});
}

$(function() {
	getItem();
	setInterval("getItem()", 30000);
});