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
          <span class="t_raex"></span><div class="t_item">Name</div><div class="t_stats">&lt;stats&gt;</div><div class="t_jobs">&lt;jobs&gt;</div>
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
          <div id="dropdown">
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
if ($loc == 1) $addclass = " current";
printf("              <li class=\"has-sub%s\"><a href=\"/db/\"><i class=\"fa fa-database\" aria-hidden=\"true\"></i></a>", $addclass);
$current = "";
$addclass = "";
echo <<<EOF
                <ul>
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
if ($loc == 2) {
  $addclass = " class=\"current\"";
  $current = " Users";
}
printf("              <li%s><a href=\"/users/\"><i class=\"fa fa-users\" aria-hidden=\"true\"></i>%s</a></li>", $addclass, $current);
$current = "";
$addclass = "";
if ($loc == 3) {
  $addclass = " class=\"current\"";
  $current = " Download";
}
printf("              <li%s><a href=\"/download/\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i>%s</a></li>", $addclass, $current);
$current = "";
$addclass = "";
if ($loc == 4) {
  $addclass = " class=\"current\"";
  $current = " Help";
}
printf("              <li%s><a href=\"/help/\"><i class=\"fa fa-life-ring\" aria-hidden=\"true\"></i>%s</a></li>", $addclass, $current);
print <<<EOF
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