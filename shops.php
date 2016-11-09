<?php

$shops = array("", "Crystal Depot", "Pharmacy", "MogDonald's", "Tools", "National Hero Specials", "Mighty Hero Specials", "Chains-Breaker Specials",
               "", "", "Curio Vendor Moogles");

$clock = true;
require("include/html.inc");
$loading = array("Loading", "Enslaving Tarutaru", "Praying to Altana", "Training to Selbina", "Darkstar Initiating");

if (isset($_GET['id'])) {
  htmlHeader(trim($_GET['id'], "/"));
  htmlDropDown(2);

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
$category = $shops[$catid];
printf("          <td id=\"shopcat\" colspan=\"4\">%s</td>", $category);
  echo <<<EOF
        </tr>
        <tr class="tbl-subhead">
          <td>&nbsp;</td>
          <th class="left">Item <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Price <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Stock <i class="fa fa-unsorted" aria-hidden="true"></i></th>
        </tr></thead>
        <tbody id="auctions">
          <tr><td colspan="4" class="center" style="padding: 4px 10px; font-size:12pt">
EOF;
  printf("            <i class=\"fa fa-refresh fa-spin fa-fw\" aria-hidden=\"true\"></i> %s", $loading[array_rand($loading)]);
  echo <<<EOF
          </td></tr>
        </tbody>
      </table>
EOF;
  // Footer
  echo "    </div>";
  htmlFooter("shops");
} else {
  include("shops-categories.php");
}

?>