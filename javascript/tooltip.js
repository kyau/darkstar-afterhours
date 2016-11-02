var displayingTooltip = false;
var toolTipDHandle;

function ClearTooltip() {
	$(".tooltip").hide();
}

function PopulateTooltip(iid, stack, handle) {
	$.ajax( {
		url: "../getitem.php",
		type: 'get',
		beforeSend: function(){
		  ClearTooltip();
		},
		dataType: 'json',
		async: true,
		data: {'id':iid,'stack':stack,'tooltip':1},
		cache: false,
		success: function(jsonData) {
			if (displayingTooltip == true) {
				$(".t_item").html(jsonData.realname);
				$(".t_mainicon").attr("src", "images/large-icons/" + jsonData.itemid + ".png");
				if (jsonData.ex == true && jsonData.rare == true) {
					$(".t_raex").html('<img src="images/icons/g_rare.png" class="i_rare"><img src="images/icons/g_exclusive.png" class="i_ex">');
				} else if (jsonData.ex == true) {
					$(".t_raex").html('<img src="images/icons/g_exclusive.png" class="i_ex">');
				} else if (jsonData.rare == true) {
					$(".t_raex").html('<img src="images/icons/g_rare.png" class="i_rare">');
				}
				if (jsonData.armor == 1) {
					$(".t_jobs").html("Lv"+jsonData.level+" &nbsp; "+jsonData.jobs);
					$(".t_stats").html(jsonData.mods);
				} else {
					$(".t_jobs").html("");
					$(".t_stats").html(jsonData.description);
				}
				
				$(".tooltip").position({
					my: "left bottom",
					at: "left top",
					of: toolTipDHandle,
					collision: "flip",
					within: "#stretch"});
				$(".tooltip").show();
			} else {
				$(".tooltip").html(" ");
				$(".tooltip").hide();
			}
		}
	});
}

// Tooltips
$("body").on("mouseenter", ".tip", function () {
	var _this = $(this);
	var tIID = parseInt($(_this).data("id"));
	var tStack = parseInt($(_this).data("stack"));
	toolTipDHandle = _this;
	PopulateTooltip(tIID, tStack, _this);
	displayingTooltip = true;
});

$("body").on("mouseleave", ".tip", function () {
	displayingTooltip = false;
	var html = '    <table class="tbl tbl-item tbl-tooltip">';
	html += '      <tbody><tr>';
	html += '        <td colspan="2"></td>';
	html += '      </tr><tr>';
	html += '        <td class="item-icon"><img src="images/large-icons/18270.png" class="t_mainicon"></td>';
	html += '        <td class="item">';
	html += '          <span class="t_raex"></span><div class="t_item">Name</div><div class="t_stats">&lt;stats&gt;</div><div class="t_jobs">&lt;jobs&gt;</div>';
	html += '        </td>';
	html += '      </tr><tr>';
	html += '        <td colspan="2" style="height:1px"></td>';
	html += '      </tr></tbody>';
	html += '    </table>';
	$(".tooltip").stop().fadeOut(0, function() {
		$(this).removeAttr("style");
	}).html(html);
});

$(function() {
	$(document).on("click", ".catlink", function (){
		iID = $(this).data("id");
		window.location.href = "https://" + location.host + '/ah/' + iID;
	});
});