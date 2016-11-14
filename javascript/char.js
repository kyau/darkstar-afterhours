function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function toFixed(value, precision) {
	var power = Math.pow(10, precision || 0);
	return String(Math.round(value * power) / power);
}

function loadStartPage() {}

function getPlayer() {
	var charid = $("body").data("id");
	$.ajax({
		url: "/getchar.php",
		type: 'get',
		dataType: 'json',
		async: true,
		cache: false,
		data: { id : charid },
		success: function(jsonData) {
			if (jsonData.name == null) {
				return 0;
			} else {
				$(document).prop('title', 'AfterHours - ' + jsonData.name);
				$("#auto_name").html(jsonData.name);
				if (jsonData.ls_name != "N/A") {
					if (jsonData.ls_rank == "1") {
						$("#auto_linkshell").html("<img src=\"images/icons/linkshell.png\" /> "+jsonData.ls_name);
					} else if (jsonData.ls_rank == "2") {
						$("#auto_linkshell").html("<img src=\"images/icons/pearlsack.png\" /> "+jsonData.ls_name);
					} else {
						$("#auto_linkshell").html("<img src=\"images/icons/linkpearl.png\" /> "+jsonData.ls_name);
					}
				}
				$("#auto_img").attr("src", jsonData.char_img);
				$("#auto_zone").html(jsonData.zone);
				$("#auto_race").html(jsonData.char_race);
				$("#auto_rank_bastok").html(jsonData.rank_bastok);
				$("#auto_rank_sandoria").html(jsonData.rank_sandoria);
				$("#auto_rank_windurst").html(jsonData.rank_windurst);
				$("#auto_maat").html(jsonData.maat);
				$("#auto_gil").html(jsonData.gil);
				$("#auto_mainjob").html(jsonData.mainjob);
				if (jsonData.subjob != "GENKAI0")
					$("#auto_subjob").html("/"+jsonData.subjob);
				else
					$("#auto_subjob").html("");

				if (jsonData.smithing == jsonData.smithingrank && jsonData.smithing != 0) {
					$("#auto_smithing").html("<span class=\"capped\">"+jsonData.smithing.toFixed(1)+"</span>");
				} else {
					$("#auto_smithing").html(jsonData.smithing.toFixed(1));
				}
				if (jsonData.clothcraft == jsonData.clothcraftrank && jsonData.clothcraft != 0) {
					$("#auto_clothcraft").html("<span class=\"capped\">"+jsonData.clothcraft.toFixed(1)+"</span>");
				} else {
					$("#auto_clothcraft").html(jsonData.clothcraft.toFixed(1));
				}
				if (jsonData.alchemy == jsonData.alchemyrank && jsonData.alchemy != 0) {
					$("#auto_alchemy").html("<span class=\"capped\">"+jsonData.alchemy.toFixed(1)+"</span>");
				} else {
					$("#auto_alchemy").html(jsonData.alchemy.toFixed(1));
				}
				if (jsonData.woodworking == jsonData.woodworkingrank && jsonData.woodworking != 0) {
					$("#auto_woodworking").html("<span class=\"capped\">"+jsonData.woodworking.toFixed(1)+"</span>");
				} else {
					$("#auto_woodworking").html(jsonData.woodworking.toFixed(1));
				}
				if (jsonData.goldsmithing == jsonData.goldsmithingrank && jsonData.goldsmithing != 0) {
					$("#auto_goldsmithing").html("<span class=\"capped\">"+jsonData.goldsmithing.toFixed(1)+"</span>");
				} else {
					$("#auto_goldsmithing").html(jsonData.goldsmithing.toFixed(1));
				}
				if (jsonData.leathercraft == jsonData.leathercraftrank && jsonData.leathercraft != 0) {
					$("#auto_leathercraft").html("<span class=\"capped\">"+jsonData.leathercraft.toFixed(1)+"</span>");
				} else {
					$("#auto_leathercraft").html(jsonData.leathercraft.toFixed(1));
				}
				if (jsonData.bonecraft == jsonData.bonecraftrank && jsonData.bonecraft != 0) {
					$("#auto_bonecraft").html("<span class=\"capped\">"+jsonData.bonecraft.toFixed(1)+"</span>");
				} else {
					$("#auto_bonecraft").html(jsonData.bonecraft.toFixed(1));
				}
				if (jsonData.cooking == jsonData.cookingrank && jsonData.cooking != 0) {
					$("#auto_cooking").html("<span class=\"capped\">"+jsonData.cooking.toFixed(1)+"</span>");
				} else {
					$("#auto_cooking").html(jsonData.cooking.toFixed(1));
				}
				if (jsonData.fishing == jsonData.fishingrank && jsonData.fishing != 0) {
					$("#auto_fishing").html("<span class=\"capped\">"+jsonData.fishing.toFixed(1)+"</span>");
				} else {
					$("#auto_fishing").html(jsonData.fishing.toFixed(1));
				}
				if (jsonData.synergy == jsonData.synergyrank && jsonData.synergy != 0) {
					$("#auto_synergy").html("<span class=\"capped\">"+jsonData.synergy.toFixed(1)+"</span>");
				} else {
					$("#auto_synergy").html(jsonData.synergy.toFixed(1));
				}

				if (jsonData.jobs.genkai == jsonData.jobs.war) {
					$("#auto_war").html("<span class=\"capped\">"+jsonData.jobs.war+"</span>");
				} else {
					$("#auto_war").html(jsonData.jobs.war);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.mnk) {
					$("#auto_mnk").html("<span class=\"capped\">"+jsonData.jobs.mnk+"</span>");
				} else {
					$("#auto_mnk").html(jsonData.jobs.mnk);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.whm) {
					$("#auto_whm").html("<span class=\"capped\">"+jsonData.jobs.whm+"</span>");
				} else {
					$("#auto_whm").html(jsonData.jobs.whm);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.blm) {
					$("#auto_blm").html("<span class=\"capped\">"+jsonData.jobs.blm+"</span>");
				} else {
					$("#auto_blm").html(jsonData.jobs.blm);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.rdm) {
					$("#auto_rdm").html("<span class=\"capped\">"+jsonData.jobs.rdm+"</span>");
				} else {
					$("#auto_rdm").html(jsonData.jobs.rdm);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.thf) {
					$("#auto_thf").html("<span class=\"capped\">"+jsonData.jobs.thf+"</span>");
				} else {
					$("#auto_thf").html(jsonData.jobs.thf);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.pld) {
					$("#auto_pld").html("<span class=\"capped\">"+jsonData.jobs.pld+"</span>");
				} else {
					$("#auto_pld").html(jsonData.jobs.pld);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.drk) {
					$("#auto_drk").html("<span class=\"capped\">"+jsonData.jobs.drk+"</span>");
				} else {
					$("#auto_drk").html(jsonData.jobs.drk);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.bst) {
					$("#auto_bst").html("<span class=\"capped\">"+jsonData.jobs.bst+"</span>");
				} else {
					$("#auto_bst").html(jsonData.jobs.bst);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.brd) {
					$("#auto_brd").html("<span class=\"capped\">"+jsonData.jobs.brd+"</span>");
				} else {
					$("#auto_brd").html(jsonData.jobs.brd);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.rng) {
					$("#auto_rng").html("<span class=\"capped\">"+jsonData.jobs.rng+"</span>");
				} else {
					$("#auto_rng").html(jsonData.jobs.rng);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.sam) {
					$("#auto_sam").html("<span class=\"capped\">"+jsonData.jobs.sam+"</span>");
				} else {
					$("#auto_sam").html(jsonData.jobs.sam);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.nin) {
					$("#auto_nin").html("<span class=\"capped\">"+jsonData.jobs.nin+"</span>");
				} else {
					$("#auto_nin").html(jsonData.jobs.nin);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.drg) {
					$("#auto_drg").html("<span class=\"capped\">"+jsonData.jobs.drg+"</span>");
				} else {
					$("#auto_drg").html(jsonData.jobs.drg);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.smn) {
					$("#auto_smn").html("<span class=\"capped\">"+jsonData.jobs.smn+"</span>");
				} else {
					$("#auto_smn").html(jsonData.jobs.smn);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.blu) {
					$("#auto_blu").html("<span class=\"capped\">"+jsonData.jobs.blu+"</span>");
				} else {
					$("#auto_blu").html(jsonData.jobs.blu);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.cor) {
					$("#auto_cor").html("<span class=\"capped\">"+jsonData.jobs.cor+"</span>");
				} else {
					$("#auto_cor").html(jsonData.jobs.cor);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.pup) {
					$("#auto_pup").html("<span class=\"capped\">"+jsonData.jobs.pup+"</span>");
				} else {
					$("#auto_pup").html(jsonData.jobs.pup);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.dnc) {
					$("#auto_dnc").html("<span class=\"capped\">"+jsonData.jobs.dnc+"</span>");
				} else {
					$("#auto_dnc").html(jsonData.jobs.dnc);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.sch) {
					$("#auto_sch").html("<span class=\"capped\">"+jsonData.jobs.sch+"</span>");
				} else {
					$("#auto_sch").html(jsonData.jobs.sch);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.geo) {
					$("#auto_geo").html("<span class=\"capped\">"+jsonData.jobs.geo+"</span>");
				} else {
					$("#auto_geo").html(jsonData.jobs.geo);
				}
				if (jsonData.jobs.genkai == jsonData.jobs.run) {
					$("#auto_run").html("<span class=\"capped\">"+jsonData.jobs.run+"</span>");
				} else {
					$("#auto_run").html(jsonData.jobs.run);
				}
				var z = 0;
				$.each(jsonData.equip, function(i, item) {
					var tmp = "";
					if (item == "0") {
						var eq = z + 1;
						if (z == 9)
							eq = 6;
						else if (z == 11)
							eq = 7;
						else if (z == 12)
							eq = 8;
						else if (z == 5)
							eq = 9;
						else if (z == 6)
							eq = 10;
						else if (z == 13)
							eq = 11;
						else if (z == 14)
							eq = 12;
						else if (z == 15)
							eq = 13;
						else if (z == 10)
							eq = 14;
						else if (z == 7)
							eq = 15;
						else if (z == 8)
							eq = 16;
						tmp = '<div id="auto_equip'+z+'" class="equipslot"><img src="images/eq'+eq+'.gif" /></div>';
					} else {
						tmp = '<div id="auto_equip'+z+'" class="equipslot"><a class="tip" data-id="'+item+'" data-stack="1" data-signature="'+jsonData.equipsig[i]+'" href="/item/'+item+'"><img src="images/large-icons/'+item+'.png" class="icon" /></a></div>';
					}
					$("#auto_equip"+i.toString()).html(tmp);
					z = z + 1;
				})
				if (typeof jsonData.missions !== 'undefined') {
					if (jsonData.missions.zilart != 'None')
						$("#auto_mission1").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.zilart.replace(" ", "%20")+"\">"+jsonData.missions.zilart+"</a>");
					else
						$("#auto_mission1").html(jsonData.missions.zilart);
					if (jsonData.missions.cop != 'None')
						$("#auto_mission2").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.cop.replace(" ", "%20")+"\">"+jsonData.missions.cop+"</a>");
					else
						$("#auto_mission2").html(jsonData.missions.cop);
					if (jsonData.missions.toau != 'None')
						$("#auto_mission3").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.toau.replace(" ", "%20")+"\">"+jsonData.missions.toau+"</a>");
					else
						$("#auto_mission3").html(jsonData.missions.toau);
					if (jsonData.missions.wotg != 'None')
						$("#auto_mission5").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.wotg.replace(" ", "%20")+"\">"+jsonData.missions.wotg+"</a>");
					else
						$("#auto_mission5").html(jsonData.missions.wotg);
					if (jsonData.missions.acp != 'None')
						$("#auto_mission7").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.acp.replace(" ", "%20")+"\">"+jsonData.missions.acp+"</a>");
					else
						$("#auto_mission7").html(jsonData.missions.acp);
					if (jsonData.missions.mxd != 'None')
						$("#auto_mission8").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.mxd.replace(" ", "%20")+"\">"+jsonData.missions.mxd+"</a>");
					else
						$("#auto_mission8").html(jsonData.missions.mxd);
					if (jsonData.missions.asa != 'None')
						$("#auto_mission9").html("<a href=\"https://www.bg-wiki.com/bg/"+jsonData.missions.asa.replace(" ", "%20")+"\">"+jsonData.missions.asa+"</a>");
					else
						$("#auto_mission9").html(jsonData.missions.asa);
				}
				$("#auctions").html("");
				$.each(jsonData.ah, function(i, item) {
					var html = "";
					html += "<tr>";
					if (item.quantity > 1) {
						html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" href=\"/item/"+item.itemid+"?stack=1\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item.itemid+".png\" /></a></td>";
						html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" href=\"/item/"+item.itemid+"?stack=1\">"+item.itemname+" <span class=\"lightgray\">x"+item.quantity+"</span></a></td>";
					} else {
						html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" href=\"/item/"+item.itemid+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item.itemid+".png\" /></a></td>";
						html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" href=\"/item/"+item.itemid+"\">"+item.itemname+"</a></td>";
					}
					html += "<td class=\"ah-date\"><a href=\"/item/"+item.itemid+"\">"+item.date+"</a></td>";
					if (item.seller == jsonData.name) {
						html += "<td class=\"ah-who\"><a class=\"ah-highlight\" href=\"/item/"+item.itemid+"\">"+item.seller+"</a></td>";
					} else {
						html += "<td class=\"ah-who\"><a href=\"/item/"+item.itemid+"\">"+item.seller+"</a></td>";
					}
					if (item.buyer == jsonData.name) {
						html += "<td class=\"ah-who\"><a class=\"ah-highlight\" href=\"/item/"+item.itemid+"\">"+item.buyer+"</a></td>";
					} else {
						html += "<td class=\"ah-who\"><a href=\"/item/"+item.itemid+"\">"+item.buyer+"</a></td>";
					}
					html += "<td class=\"ah-price\"><a href=\"/item/"+item.itemid+"\">"+item.price+"</a></td>";
					html += "</tr>";
					$("#auctions").append(html);
				});
				$("#bazaar").html("");
				console.log(jsonData.bazaar);
				if (jsonData.bazaar.length != 0) {
					$.each(jsonData.bazaar, function(i, item) {
						var html = "";
						html += "<tr>";
						if (item.quantity > 1) {
							html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" data-signature=\""+item.signature+"\" href=\"/item/"+item.itemid+"?stack=1\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item.itemid+".png\" /></a></td>";
							html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" data-signature=\""+item.signature+"\" href=\"/item/"+item.itemid+"?stack=1\">"+item.itemname+" <span class=\"lightgray\">x"+item.quantity+"</span></a></td>";
						} else {
							html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" data-signature=\""+item.signature+"\" href=\"/item/"+item.itemid+"\"><img class=\"mini-icon\" src=\"images/mini-icons/"+item.itemid+".png\" /></a></td>";
							html += "<td><a class=\"tip\" data-id=\""+item.itemid+"\" data-signature=\""+item.signature+"\" href=\"/item/"+item.itemid+"\">"+item.itemname+"</a></td>";
						}
						html += "<td class=\"center\"><a href=\"/item/"+item.itemid+"\">"+item.price+"</a></td>";
						if (item.ahprice == 0) {
							html += "<td class=\"center\"><span class=\"lightgray\">0</span></td>";
						} else if (item.ahprice < 0)
							html += "<td class=\"center\"><span class=\"red\">("+numberWithCommas(Math.abs(item.ahprice))+")</span></td>";
						else
							html += "<td class=\"center\"><span class=\"green\">+"+numberWithCommas(item.ahprice)+"</span></td>";
						html += "</tr>";
						$("#bazaar").append(html);
					});
					$(".tbl-bazaar").css("display", "inline-block");
				}
			}
		}
	});
}

$(function() {
	getPlayer();
	setInterval("getPlayer()", 30000);
});