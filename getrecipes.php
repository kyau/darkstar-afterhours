<?php

require("include/html.inc");

$ranks = array("", "Amateur (1-10)", "Recruit (11-20)", "Initiate (21-30)", "Novice (31-40)", "Apprentice (41-50)", "Journeyman (51-60)", "Craftsman (61-70)",
               "Artisan (71-80)", "Adept (81-90)", "Veteran (91-100)", "Expert (101-110)", "Authority (111-120)");
$crafts = array("alchemy" => "Alchemy", "bone" => "Bonecraft", "cloth" => "Clothcraft", "cook" => "Cooking", "gold" => "Goldsmithing", "leather" => "Leathercraft", "smith" => "Smithing", "wood" => "Woodworking");

$compiled = array();
if (isset($_GET['cat']) && isset($_GET['rank'])) {
	$craft = $_GET['cat'];
	$rank = $_GET['rank'];
	$rankmax = $rank * 10;
	$rankmin = $rankmax - 9;

	$rank = $ranks[$_GET['rank']];
	$category = $crafts[$_GET['cat']]." - ".$rank;
	$compiled["category"] = $category;

	$sql = "SELECT * FROM `synth_recipes` WHERE `".$craft."` = GREATEST(`Alchemy`,`Bone`,`Cloth`,`Cook`,`Gold`,`Leather`,`Smith`,`Wood`) AND `".$craft."` > ".($rankmin-1)." AND `".$craft."` < ".($rankmax+1)." ORDER BY `synth_recipes`.`".$craft."` ASC";
	$tmp = mysqli_query($dcon, $sql);
	$recipes = array();
	$count = 0;
	while($recipe = $tmp->fetch_assoc()) {
		$recipes[$count]["id"] = $recipe["ID"];
		$recipes[$count]["alchemy"] = $recipe["Alchemy"];
		$recipes[$count]["bone"] = $recipe["Bone"];
		$recipes[$count]["cloth"] = $recipe["Cloth"];
		$recipes[$count]["cook"] = $recipe["Cook"];
		$recipes[$count]["gold"] = $recipe["Gold"];
		$recipes[$count]["leather"] = $recipe["Leather"];
		$recipes[$count]["smith"] = $recipe["Smith"];
		$recipes[$count]["wood"] = $recipe["Wood"];
		$cname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipe["Crystal"])["realname"]);
		$cname = str_replace("The", "the", str_replace("Of", "of", $cname));
		$rname = $recipe["Crystal"].":".$cname;
		$recipes[$count]["crystal"] = $rname;
		$ingredients = array();
		$recipecost = 0;
		for ($i = 1; $i < 9; $i++) {
			$name = "Ingredient".$i;
			if ($recipe[$name] == 0)
				continue;
			$itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipe[$name])["realname"]);
			$itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
			$rname = $recipe[$name].":".$itemname;
			if (array_key_exists($rname, $ingredients)) {
				$ingredients[$rname] += 1;
			} else {
				$ingredients[$rname] = 1;
			}
		}
		foreach ($ingredients as $key => $quantity) {
			$itemid = explode(":", $key)[0];
			$cost = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$itemid." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
			$recipecost += ($cost * $quantity);
		}
		$recipes[$count]["ingredients"] = $ingredients;
		$recipes[$count]["ingredientcost"] = $recipecost;

		$recipes[$count]["price"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipe["Result"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
		$recipes[$count]["pricestack"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipe["Result"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 1")["price"];
		$recipes[$count]["stacksize"] = sqlQuery("SELECT stackSize FROM `item_basic` WHERE itemid = ".$recipe["Result"])["stackSize"];
		if ($recipe["Result"] != $recipe["ResultHQ1"])
			$recipes[$count]["pricehq1"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipe["ResultHQ1"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
		else
			$recipes[$count]["pricehq1"] = 0;
		if ($recipe["ResultHQ1"] != $recipe["ResultHQ2"])
			$recipes[$count]["pricehq2"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipe["ResultHQ2"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
		else
			$recipes[$count]["pricehq2"] = 0;
		if ($recipe["ResultHQ2"] != $recipe["ResultHQ3"])
			$recipes[$count]["pricehq3"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipe["ResultHQ3"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
		else
			$recipes[$count]["pricehq3"] = 0;

		$itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipe["Result"])["realname"]);
		$itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
		$rname = $recipe["Result"].":".$itemname;
		$recipes[$count]["result"] = $rname;
		$recipes[$count]["resultcount"] = $recipe["ResultQty"];

		$itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipe["ResultHQ1"])["realname"]);
		$itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
		$rname = $recipe["ResultHQ1"].":".$itemname;
		$recipes[$count]["resulthq1"] = $rname;
		$recipes[$count]["resulthq1count"] = $recipe["ResultHQ1Qty"];

		$itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipe["ResultHQ2"])["realname"]);
		$itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
		$rname = $recipe["ResultHQ2"].":".$itemname;
		$recipes[$count]["resulthq2"] = $rname;
		$recipes[$count]["resulthq2count"] = $recipe["ResultHQ2Qty"];

		$itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipe["ResultHQ3"])["realname"]);
		$itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
		$rname = $recipe["ResultHQ3"].":".$itemname;
		$recipes[$count]["resulthq3"] = $rname;
		$recipes[$count]["resulthq3count"] = $recipe["ResultHQ3Qty"];

		$count++;
	}
  $compiled["recipes"] = $recipes;
}

$json = json_encode($compiled);
echo $json;

?>