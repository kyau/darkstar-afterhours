<?php

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");

if (isset($_GET['id'])) {
  $sql = "SELECT itemid, realname FROM `item_info` WHERE realname LIKE '%".str_replace(" ", "%", $dcon->real_escape_string($_GET['id']))."%' OR sortname LIKE '%".str_replace(" ", "%", $dcon->real_escape_string($_GET['id']))."%' ORDER BY realname";
  $tmp = mysqli_query($dcon, $sql);
  $items = array();
  $count = 0;
  while($item = $tmp->fetch_assoc()) {
    $items[$count]["itemid"] = intval($item["itemid"]);
    $name = ucwords($item['realname']);
    //$name = str_replace("_", " ", $item["name"]);
    //$name = mb_eregi_replace('\bM{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})\b', "strtoupper('\\0')", $name, 'e');
    //$name = ucwords($name);
    $name = str_replace("The", "the", str_replace("Of", "of", $name));
    $items[$count]["itemname"] = $name;
    $stackSize = sqlQuery("SELECT stackSize FROM `item_basic` WHERE itemid = ".$item["itemid"])["stackSize"];
    $items[$count]["stack"] = intval($stackSize);
    $level = intval(sqlQuery("SELECT level FROM `item_armor` WHERE itemId = ".$item["itemid"])["level"]);
    if (!isset($level))
      $level = 0;
    $items[$count]["level"] = $level;
    $stacked = 0;
    if (intval($stackSize) > 1)
      $stacked = 1;
    $price = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$item["itemid"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = ".$stacked)["price"];
    if (!isset($price))
      $price = "0";
    $items[$count]["price"] = number_format($price);
    $instock = sqlQuery("SELECT COUNT(*) FROM `auction_house` WHERE itemid = ".$item["itemid"]." AND seller_name = 'DarkStar' AND buyer_name IS NULL")["COUNT(*)"];
    $items[$count]["instock"] = $instock;
    $count++;
  }
  //$compiled["items"] = $items;

  htmlHeader();
  htmlDropDown(1);

  echo <<<EOF
    </div>
    <div id="content">
      <br/>

EOF;

  //
  // Auction House
  //
  echo <<<EOF
      <table class="tbl tbl-ahcat tbl-hover">
        <thead><tr class="tbl-head">
EOF;
printf("          <td id=\"ahcat\" colspan=\"5\">Search Results: %s</td>", $_GET['id']);
  echo <<<EOF
        </tr>
        <tr class="tbl-subhead">
          <td>&nbsp;</td>
          <th class="left">Item <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Level <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Price <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Stock <i class="fa fa-unsorted" aria-hidden="true"></i></th>
        </tr></thead>
        <tbody id="auctions">
EOF;
  for ($i = 0; $i < count($items); $i++) {
    $stackhtml = "";
    if ($items[$i]["stack"] > 1)
      $stackhtml = "?stack=1";
    echo "<tr>";
    echo "<td><a class=\"tip\" data-id=\"".$items[$i]["itemid"]."\" data-stack=\"1\" href=\"/item/".$items[$i]["itemid"].$stackhtml."\"><img class=\"mini-icon\" src=\"images/mini-icons/".$items[$i]["itemid"].".png\" /></a></td>";
    echo "<td class=\"left\"><a class=\"tip\" data-id=\"".$items[$i]["itemid"]."\" data-stack=\"1\" href=\"/item/".$items[$i]["itemid"].$stackhtml."\">".$items[$i]["itemname"]."</a>";
    if ($items[$i]["stack"] > 1)
      echo " x".$items[$i]["itemid"];
    echo "</td>";
    echo "<td class=\"center\">".$items[$i]["level"]."</td>";
    echo "<td class=\"center\">".$items[$i]["price"]."</td>";
    echo "<td class=\"center\">".$items[$i]["instock"]."</td>";
    echo "</tr>";
  }
  echo <<<EOF
        </tbody>
      </table>
      <br/><br/>
      <form method="get" class="searchBox" action="/search.php">
EOF;
  printf("        <input class=\"home-search searchBoxInput\" type=\"text\" autocomplete=\"off\" name=\"id\" size=\"32\" value=\"%s\" placeholder=\"Search here...\"><br/>", $_GET["id"]);
  echo <<<EOF
        <i class="fa fa-search submit" aria-hidden="true"></i>
      </form>
EOF;
  // Footer
  echo "    </div>";
  htmlFooter("search");
} else {
  header('Location: https://ffxi.kyau.net:4444/');
}

?>