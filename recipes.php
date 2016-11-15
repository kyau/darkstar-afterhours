<?php

$ranks = array("", "Amateur (1-10)", "Recruit (11-20)", "Initiate (21-30)", "Novice (31-40)", "Apprentice (41-50)", "Journeyman (51-60)", "Craftsman (61-70)",
               "Artisan (71-80)", "Adept (81-90)", "Veteran (91-100)", "Expert (101-110)", "Authority (111-120)");
$crafts = array("alchemy" => "Alchemy", "bone" => "Bonecraft", "cloth" => "Clothcraft", "cook" => "Cooking", "gold" => "Goldsmithing", "leather" => "Leathercraft", "smith" => "Smithing", "wood" => "Woodworking");

$clock = true;
require("include/html.inc");
$loading = array("Loading", "Enslaving Tarutaru", "Praying to Altana", "Training to Selbina", "Darkstar Initiating");

if (isset($_GET['cat']) && isset($_GET['rank'])) {
  htmlHeader(trim($_GET['cat'], "/"), trim($_GET['rank'], "/"));
  htmlDropDown(6);

  echo <<<EOF
    </div>
    <div id="content">

EOF;

  //
  // Crafting Recipes Header
  //
  echo <<<EOF
     <table class="tbl tbl-ahcathead" style="margin-bottom:10px">
       <tbody class="recipes-header"></tbody>
     </table>
     <br/>
EOF;

  //
  // Crafting Recipes
  //
  echo <<<EOF
      <table class="tbl tbl-recipes">
        <thead><tr class="tbl-head">
EOF;
$rank = $ranks[$_GET['rank']];
$category = $crafts[$_GET['cat']]." &mdash; ".$rank;
printf("          <td id=\"recipecat\" colspan=\"4\"><i class=\"fa fa-diamond\" aria-hidden=\"true\"></i> %s</td>", $category);
  echo <<<EOF
        </tr>
        <tr class="tbl-subhead">
          <th class="center">Skills <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Ingredients <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th class="center">Results <i class="fa fa-unsorted" aria-hidden="true"></i></th>
        </tr></thead>
        <tbody id="recipes">
          <tr><td colspan="4" class="center" style="padding: 4px 10px; font-size:12pt">
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
  htmlFooter("recipes");
} else {
  include("recipes-categories.php");
}

?>