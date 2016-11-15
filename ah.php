<?php

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");
$loading = array("Loading", "Enslaving Tarutaru", "Praying to Altana", "Training to Selbina", "Darkstar Initiating");

if (isset($_GET['id'])) {
  htmlHeader(trim($_GET['id'], "/"));
  htmlDropDown(1);

  echo <<<EOF
    </div>
    <div id="content">

EOF;

  //
  // Auction House
  //
  echo <<<EOF
      <table class="tbl tbl-ahcat">
        <thead><tr class="tbl-head">
EOF;
$catid = $_GET['id'];
$category = getCategory($catid);
printf("          <td id=\"ahcat\" colspan=\"6\"><i class=\"fa fa-balance-scale\" aria-hidden=\"true\"></i> %s</td>", $category);
  echo <<<EOF
        </tr>
        <tr class="tbl-subhead">
          <td>&nbsp;</td>
          <th class="left">Item <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Level <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">DPS <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Price <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Stock <i class="fa fa-unsorted" aria-hidden="true"></i></th>
        </tr></thead>
        <tbody id="auctions">
          <tr><td colspan="6" class="center" style="padding: 4px 10px; font-size:12pt">
EOF;
  printf("            <i class=\"fa fa-refresh fa-spin fa-fw\" aria-hidden=\"true\"></i> %s", $loading[array_rand($loading)]);
  echo <<<EOF
          </td></tr>
        </tbody>
      </table>
EOF;
  // Footer
  echo "      <div id=\"toTop\"><i class=\"fa fa-caret-square-o-up\" aria-hidden=\"true\"></i></div>";
  echo "    </div>";
  htmlFooter("ah");
} else {
  include("ah-categories.php");
}

?>