<?php

error_reporting(-1);
ini_set('display_errors', 'On');
date_default_timezone_set('America/Los_Angeles');

if (file_exists('include/config.inc')) include_once 'include/config.inc';

$categories = array(0 => "", 1 => "Hand to Hand", 2 => "Daggers", 3 => "Swords", 4 => "Great Swords", 5 =>"Axes", 6 => "Great Axes", 7=> "Scythes", 8 => "Polearms", 9 => "Katana", 10 => "Great Katana", 11 => "Clubs", 12 => "Staves", 13 => "Ranged", 14 => "Instruments", 15 => "Ammunition",
                    16 => "Shields", 17 => "Head", 18 => "Body", 19 => "Hands", 20 => "Legs", 21 => "Feet", 22 => "Neck", 23 => "Waist", 24 => "Earrings", 25 => "Rings", 26 => "Back",
                    28 => "White Magic", 29 => "Black Magic", 30 => "Summoning", 31 => "Ninjutsu", 32 => "Songs",
                    33 => "Medicines",
                    34 => "Furnishings",
                    35 => "Crystals",
                    36 => "Cards",
                    37 => "Cursed Items",
                    38 => "Smithing",
                    39 => "Goldsmithing",
                    40 => "Clothcraft",
                    41 => "Leathercraft",
                    42 => "Bonecraft",
                    43 => "Woodworking",
                    44 => "Alchemy",
                    46 => "Misc.",
                    47 => "Fishing Gear",
                    48 => "Pet Items",
                    49 => "Ninja Tools",
                    50 => "Beast-made",
                    51 => "Fish",
                    52 => "Meat & Eggs",
                    53 => "Seafood",
                    54 => "Vegetables",
                    55 => "Soups",
                    56 => "Breads & Rice",
                    57 => "Sweets",
                    58 => "Drinks",
                    59 => "Ingredients",
                    60 => "Dice",
                    61 => "Automatons",
                    62 => "Grips");

// connect to the database
$dcon = new mysqli("localhost", $db_login, $db_password, $db_name);
if ($dcon->connect_error) {
  die("<div id=\"error\">Failed to connect to database.</div>");
}
$dcon->set_charset("utf8");

function htmlHeader($id = "", $stack = 0) {
  global $clock;
  $idtitle = "";
  $html = <<<EOF
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <base href='//ffxi.kyau.net:4444/' />
  <link rel="stylesheet" type="text/css" href="css/main.css" />
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
EOF;
  if ($id != "") {
    $idtitle .= " data-id=\"".$id."\"";
  }
  $idtitle .= " data-stack=\"".$stack."\"";
  $html = $html . "  <title>AfterHours</title>\n</head>\n\n";
  $html = $html . "<body".$idtitle.">\n";
  $html = $html . <<<EOF
  <div id="stretch">
    <a href="https://github.com/DarkstarProject/darkstar"><img id="darkstar" src="images/darkstar.png" /></a>
    <img id="logo" src="images/logo.png" />
    <div id="header">
      <a href="/"><h1>After<span>Hours</span></h1></a>
EOF;
  echo $html;
}

function htmlFooter($add = "") {
  global $clock;
  $html = "";
  if (isset($clock)) {
    if ($clock) {
      $html = $html . <<<EOF

    <div id="chatbox"><div id="chat"></div></div>
    <div id="footer">
      <div id="closed">&nbsp;</div>
      <table cellspacing="0" width="100%">
        <tr><td>
          <span id='vTime'>&nbsp;</span> &mdash; <span id="vDate">&nbsp;</span>
        </td></tr>
        <tr><td><span id="mPhase">&nbsp;</span></td></tr>
      </table>
    </div>
EOF;
    }
  }
  $html = $html . <<<EOF

  </div>
  <div class="tooltip" id="tooltip">
    <table class="tbl tbl-item">
      <tbody><tr>
        <td colspan="2"></td>
      </tr><tr>
        <td class="item-icon"><img src="images/large-icons/18270.png" class="t_mainicon"></td>
        <td class="item">
          <span class="t_raex"></span><div class="t_item">Name</div><div class="t_stats">&lt;stats&gt;</div><div class="t_jobs">&lt;jobs&gt;</div><span class="t_signature"></span>
        </td>
      </tr><tr>
        <td colspan="2" style="height:1px"></td>
      </tr></tbody>
    </table>
  </div>
  <script type="text/javascript" src="//code.jquery.com/jquery-3.1.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="javascript/jquery.tablesorter.combined.min.js"></script>
  <script type="text/javascript" src="//use.fontawesome.com/581a1fb64d.js"></script>
EOF;
  if ($add == "char") {
    $html .= "  <script type=\"text/javascript\" src=\"javascript/char.js\"></script>\n";
  } else if ($add == "users") { 
    $html .= "  <script type=\"text/javascript\" src=\"javascript/users.js\"></script>\n";
  } else if ($add == "item") { 
    $html .= "  <script type=\"text/javascript\" src=\"javascript/item.js\"></script>\n";
  } else if ($add == "ah") { 
    $html .= "  <script type=\"text/javascript\" src=\"javascript/ah.js\"></script>\n";
  } else if ($add == "recipes") { 
    $html .= "  <script type=\"text/javascript\" src=\"javascript/recipes.js\"></script>\n";
  } else if ($add == "shops") { 
    $html .= "  <script type=\"text/javascript\" src=\"javascript/shops.js\"></script>\n";
  } else if ($add == "search") { 
    $html .= "  <script type=\"text/javascript\" src=\"javascript/search.js\"></script>\n";
  } else {
    $html .= "  <script type=\"text/javascript\" src=\"javascript/online.js\"></script>\n";
  }
  $html .= "  <script type=\"text/javascript\" src=\"javascript/chat.js\"></script>\n";
  $html .= "  <script type=\"text/javascript\" src=\"javascript/tooltip.js\"></script>\n";

  if (isset($clock)) {
    if ($clock) {
      $html = $html . "  <script type=\"text/javascript\" src=\"javascript/clock.js\"></script>\n";
    }
  }
  $html = $html . <<<EOF
</body>
</html>
EOF;
  echo $html;
}

function htmlDropDown($loc = 0) {
echo <<<EOF
          <div class="dropdown">
            <ul>
EOF;
$addclass = "";
$current = "";
if ($loc == 0) {
  $addclass = " class=\"current\"";
  $current = " Online <span class='totalOnline'></span>";
}
printf("              <li%s><a href=\"/\"><i class=\"fa fa-refresh\" aria-hidden=\"true\"></i>%s</a></li>", $addclass, $current);
$current = "";
$addclass = "";
if ($loc == 1) {
  $addclass = " current";
  $current = " AH";
}
printf("              <li class=\"has-sub%s\"><a href=\"/ah/\"><i class=\"fa fa-balance-scale\" aria-hidden=\"true\"></i>%s</a>", $addclass, $current);
$current = "";
$addclass = "";
echo <<<EOF
                <ul>
                  <li><a class="menu-head"><span>Auction House</span></a></li>
                  <li role=separator" class="divider"></li>
                  <li class="has-sub"><a class="link"><span>Weapons</span></a>
                  <ul>
                    <li><a class="link catlink" data-id="1"><span>Hand to Hand</span></a></li>
                    <li><a class="link catlink" data-id="2"><span>Daggers</span></a></li>
                    <li><a class="link catlink" data-id="3"><span>Swords</span></a></li>
                    <li><a class="link catlink" data-id="4"><span>Great Swords</span></a></li>
                    <li><a class="link catlink" data-id="5"><span>Axes</span></a></li>
                    <li><a class="link catlink" data-id="6"><span>Great Axes</span></a></li>
                    <li><a class="link catlink" data-id="7"><span>Scythes</span></a></li>
                    <li><a class="link catlink" data-id="8"><span>Polearms</span></a></li>
                    <li><a class="link catlink" data-id="9"><span>Katana</span></a></li>
                    <li><a class="link catlink" data-id="10"><span>Great Katana</span></a></li>
                    <li><a class="link catlink" data-id="11"><span>Clubs</span></a></li>
                    <li><a class="link catlink" data-id="12"><span>Staves</span></a></li>
                    <li><a class="link catlink" data-id="13"><span>Ranged</span></a></li>
                    <li><a class="link catlink" data-id="14"><span>Instuments</span></a></li>
                    <li class="has-sub"><a class="link"><span>Ammo & Misc</span></a>
                      <ul>
                        <li><a class="link catlink" data-id=""><span>Pet Items</span></a></li>
                        <li><a class="link catlink" data-id=""><span>Fishing Gear</span></a></li>
                        <li><a class="link catlink" data-id="15"><span>Ammunition</span></a></li>
                        <li><a class="link catlink" data-id=""><span>Grips</span></a></li>
                      </ul>
                    </li>
                  </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Armour</span></a>
                    <ul>
                      <li><a class="link catlink" data-id="16"><span>Shields</span></a></li>
                      <li><a class="link catlink" data-id="17"><span>Head</span></a></li>
                      <li><a class="link catlink" data-id="22"><span>Neck</span></a></li>
                      <li><a class="link catlink" data-id="18"><span>Body</span></a></li>
                      <li><a class="link catlink" data-id="19"><span>Hands</span></a></li>
                      <li><a class="link catlink" data-id="23"><span>Waist</span></a></li>
                      <li><a class="link catlink" data-id="20"><span>Legs</span></a></li>
                      <li><a class="link catlink" data-id="21"><span>Feet</span></a></li>
                      <li><a class="link catlink" data-id="26"><span>Back</span></a></li>
                      <li><a class="link catlink" data-id="24"><span>Earrings</span></a></li>
                      <li><a class="link catlink" data-id="25"><span>Rings</span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Scrolls</span></a>
                    <ul>
                      <li><a class="link catlink" data-id="28"><span>White Magic</span></a></li>
                      <li><a class="link catlink" data-id="29"><span>Black Magic</span></a></li>
                      <li><a class="link catlink" data-id="32"><span>Songs</span></a></li>
                      <li><a class="link catlink" data-id="31"><span>Ninjutsu</span></a></li>
                      <li><a class="link catlink" data-id="30"><span>Summoning</span></a></li>
                      <li><a class="link catlink" data-id="60"><span>Dice</span></a></li>
                    </ul>
                  </li>
                  <li><a class="link catlink" data-id="33"><span>Medicines</span></a></li>
                  <li><a class="link catlink" data-id="34"><span>Furnishings</span></a></li>
                  <li class="has-sub"><a class="link"><span>Materials</span></a>
                    <ul>
                      <li><a class="link catlink" data-id="44"><span>Alchemy</span></a></li>
                      <li><a class="link catlink" data-id="42"><span>Bonecraft</span></a></li>
                      <li><a class="link catlink" data-id="40"><span>Clothcraft</span></a></li>
                      <li><a class="link catlink" data-id="39"><span>Goldsmithing</span></a></li>
                      <li><a class="link catlink" data-id="41"><span>Leathercraft</span></a></li>
                      <li><a class="link catlink" data-id="38"><span>Smithing</span></a></li>
                      <li><a class="link catlink" data-id="43"><span>Woodworking</span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Food</span></a>
                    <ul>
                      <li class="has-sub"><a class="link"><span>Meals</span></a>
                        <ul>
                          <li><a class="link catlink" data-id="52"><span>Meat & Eggs</span></a></li>
                          <li><a class="link catlink" data-id="53"><span>Seafood</span></a></li>
                          <li><a class="link catlink" data-id="54"><span>Vegetables</span></a></li>
                          <li><a class="link catlink" data-id="55"><span>Soups</span></a></li>
                          <li><a class="link catlink" data-id="56"><span>Bread & Rice</span></a></li>
                          <li><a class="link catlink" data-id="57"><span>Sweets</span></a></li>
                          <li><a class="link catlink" data-id="58"><span>Drinks</span></a></li>
                        </ul>
                      </li>
                      <li><a class="link catlink" data-id="59"><span>Ingredients</span></a></li>
                      <li><a class="link catlink" data-id="51"><span>Fish</span></a></li>
                    </ul>
                  </li>
                  <li><a class="link catlink" data-id="35"><span>Crystals</span></a></li>
                  <li class="has-sub"><a class="link"><span>Others</span></a>
                    <ul>
                      <li><a class="link catlink" data-id="46"><span>Misc</span></a></li>
                      <li><a class="link catlink" data-id="50"><span>Beast-Made</span></a></li>
                      <li><a class="link catlink" data-id="36"><span>Cards</span></a></li>
                      <li><a class="link catlink" data-id="49"><span>Ninja Tools</span></a></li>
                      <li><a class="link catlink" data-id="37"><span>Cursed Items</span></a></li>
                      <li><a class="link catlink" data-id="61"><span>Automatons</span></a></li>
                    </ul>
                  </li>
                </ul>
              </li>
EOF;
if ($loc == 6) {
  $addclass = " current recipemenu";
  $current = " Recipes";
}
printf("              <li class=\"has-sub%s\"><a href=\"/recipes/\"><i class=\"fa fa-diamond\" aria-hidden=\"true\"></i>%s</a>", $addclass, $current);
print <<<EOF
                <ul>
                  <li><a class="menu-head"><span>Recipes</span></a></li>
                  <li role=separator" class="divider"></li>
                  <li class="has-sub"><a class="link"><span>Alchemy</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="alchemy" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Bonecraft</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="bone" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="bone" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Clothcraft</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="cloth" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Cooking</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="cook" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="cook" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Goldsmithing</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="gold" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="gold" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Leathercraft</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="leather" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="leather" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Smithing</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="smith" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="smith" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                  <li class="has-sub"><a class="link"><span>Woodworking</span></a>
                    <ul>
                      <li><a class="link recipelink" data-craft="wood" data-rank="1">Amateur<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="2">Recruit<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="3">Initiate<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="4">Novice<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="5">Apprentice<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="6">Journeyman<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="7">Craftsman<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="8">Artisan<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="9">Adept<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="10">Veteran<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="11">Expert<span></a></li>
                      <li><a class="link recipelink" data-craft="wood" data-rank="12">Authority<span></a></li>
                    </ul>
                  </li>
                </ul>
              </li>
EOF;
$current = "";
$addclass = "";
if ($loc == 2) {
  $addclass = " current shopsmenu";
  $current = " Shops";
}
printf("              <li class=\"has-sub%s\"><a href=\"/shops/\"><i class=\"fa fa-shopping-basket\" aria-hidden=\"true\"></i>%s</a>", $addclass, $current);
print <<<EOF
                <ul>
                  <li><a class="menu-head"><span>Custom Shops</span></a></li>
                  <li role=separator" class="divider"></li>
                  <li class="has-sub"><a class="link"><span>Mogshops</span></a>
                    <ul>
                      <li><a class="link shoplink" data-id="1">Crystal Depot<span></a></li>
                      <li><a class="link shoplink" data-id="2">Pharmacy<span></a></li>
                      <li><a class="link shoplink" data-id="3">MogDonald's<span></a></li>
                      <li><a class="link shoplink" data-id="4">Tools<span></a></li>
                      <li><a class="link shoplink" data-id="5">National Hero Specials<span></a></li>
                      <li><a class="link shoplink" data-id="6">Mighty Hero Specials<span></a></li>
                      <li><a class="link shoplink" data-id="7">Chains-Breaker Specials<span></a></li>
                    </ul>
                  </li>
                  <li><a class="link shoplink" data-id="10"><span>Curio Moogles</span></a></li>
                </ul>
              </li>
EOF;
$current = "";
$addclass = "";
if ($loc == 3) {
  $addclass = " class=\"current\"";
  $current = " Users";
}
printf("              <li%s><a href=\"/users/\"><i class=\"fa fa-users\" aria-hidden=\"true\"></i>%s</a></li>", $addclass, $current);
$current = "";
$addclass = "";
if ($loc == 4) {
  $addclass = " class=\"current\"";
  $current = " Download";
}
printf("              <li%s><a href=\"/download/\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i>%s</a></li>", $addclass, $current);
$current = "";
$addclass = "";
if ($loc == 5) {
  $addclass = " class=\"current has-sub helpmenu\"";
  $current = " Help";
} else {
  $addclass = " class=\"has-sub\"";
}
printf("              <li%s><a href=\"/help/\"><i class=\"fa fa-life-ring\" aria-hidden=\"true\"></i>%s</a>", $addclass, $current);
print <<<EOF
                <ul>
                  <li><a class="menu-head"><span>Getting Help</span></a></li>
                  <li role=separator" class="divider"></li>
                  <li><a class="link" href="/help/#commands"><span>Commands</span></a></li>
                  <li><a class="link" href="/help/#faq"><span>FAQ</span></a></li>
                </ul>
              </li>
            </ul>
          </div>
EOF;
}

function getCategory($catid) {
  global $categories;
  $maincat = "";
  if ($catid > 0 && $catid < 15)
    $maincat = "Weapons &gt; ";
  if (($catid > 46 && $catid < 49) || $catid == 15)
    $maincat = "Weapons &gt; Ammo&Misc &gt; ";
  if ($catid > 15 && $catid < 27)
    $maincat = "Armour &gt; ";
  if (($catid > 27 && $catid < 33) || $catid == 60)
    $maincat = "Scrolls &gt; ";
  if ($catid == 37 || $catid == 50 || $catid == 49 || $catid == 46 || $catid == 36 || $catid == 61)
    $maincat = "Others &gt; ";
  if ($catid > 37 && $catid < 45)
    $maincat = "Materials &gt; ";
  if ($catid > 51 && $catid < 58)
    $maincat = "Food &gt; Meals &gt; ";
  if ($catid == 51 || $catid == 59)
    $maincat = "Food &gt; ";
  $cat = "";
  if (isset($categories[$catid]))
    $cat = $categories[$catid];
  return sprintf("%s%s", $maincat, $cat);
}

function sqlQuery($sql) {
  global $dcon;
  if (isset($sql)) {
    $tmp = mysqli_query($dcon, $sql);
    if(mysqli_num_rows($tmp) > 1) {
      echo "Found multiple items?!?!<br/>{".$sql."}";
      exit(1);
    }
    return $tmp->fetch_assoc();
  }
}

?>