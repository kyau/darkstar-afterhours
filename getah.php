<?php

require("include/html.inc");

function romanic_number($integer, $upcase = true) {
	$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
	$return = '';
	while($integer > 0) {
		foreach($table as $rom=>$arb) {
			if($integer >= $arb) {
				$integer -= $arb;
				$return .= $rom;
				break;
			}
		}
	}
	return $return;
}

$compiled = array();
if (isset($_GET['id'])) {
	$ahid = $_GET['id'];
	$compiled["category"] = $ahid;

	$sql = "SELECT itemid, name, stackSize FROM `item_basic` WHERE aH = ".$_GET['id']." ORDER BY name";
	$tmp = mysqli_query($dcon, $sql);
	$items = array();
	$count = 0;
	while($item = $tmp->fetch_assoc()) {
		$items[$count]["itemid"] = intval($item["itemid"]);
		$name = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$item["itemid"])["realname"]);
		/*$name = str_replace("_", " ", $item["name"]);
		$name = mb_eregi_replace('\bM{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})\b', "strtoupper('\\0')", $name, 'e');*/
		$name = str_replace("The", "the", str_replace("Of", "of", $name));
		$items[$count]["itemname"] = $name;
		$items[$count]["stack"] = intval($item["stackSize"]);
		$level = intval(sqlQuery("SELECT level FROM `item_armor` WHERE itemId = ".$item["itemid"])["level"]);
		if (!isset($level))
			$level = 0;
		$items[$count]["level"] = $level;
		$stacked = 0;
		if (intval($item["stackSize"]) > 1)
			$stacked = 1;
		$price = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$item["itemid"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = ".$stacked)["price"];
		if (!isset($price))
			$price = "0";
		$items[$count]["price"] = number_format($price);
		$instock = sqlQuery("SELECT COUNT(*) FROM `auction_house` WHERE itemid = ".$item["itemid"]." AND seller_name = 'DarkStar' AND buyer_name IS NULL")["COUNT(*)"];
		$items[$count]["instock"] = $instock;
		$weapon = sqlQuery("SELECT * FROM `item_weapon` WHERE itemid = ".$item["itemid"]);
	    $dps = 0;
	    if ($weapon != null) {
			$itemdelay = $weapon["delay"];
			$itemdmg = $weapon["dmg"];
			$dps = round(($itemdmg * 60 / ($itemdelay) * 100), 2);
	    }
	    $items[$count]["dps"] = $dps;
		$count++;
	}
  $compiled["items"] = $items;
}

$json = json_encode($compiled);
echo $json;

?>