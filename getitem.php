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

if (!isset($_GET["tooltip"]))
  $tooltip = false;
else
  $tooltip = $_GET["tooltip"];

if (!isset($_GET["stack"]))
  $stackSize = 0;
else
  $stackSize = $_GET["stack"];


$compiled = array();
$space = " ";
$jobs = array("GENKAI","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH","GEO","RUN");
$skill = array(0 => "NONE", 1 => "Hand-to-Hand", 2 => "Dagger", 3 => "Sword", 4 => "Great Sword", 5 => "Axe", 6 => "Great Axe", 7 => "Scythe", 8 => "Polearm", 9 => "Katana", 10 => "Great Katana", 11 => "Club", 12 => "Staff", 25 => "Archery", 26 => "Marksmanship", 27 => "Throwing", 28 => "Guard", 29 => "Evasion", 30 => "Shield", 31 => "Parrying", 32 => "Divine Magic", 33 => "Healing Magic", 34 => "Enhancing Magic", 35 => "Enfeebling Magic", 36 => "Elemental Magic", 37 => "Dark Magic", 38 => "Summoning Magic", 39 => "Ninjutsu", 40 => "Singing", 41 => "String", 42 => "Wind", 43 => "Blue Magic", 44 => "Geomancy", 45 => "HND?", 255 => "Pet Items");
$ws = array(10 => "Final Heaven", 11 => "Ascetic's Fury", 12 => "Stringing Pummel", 14 => "Victory Smite", 26 => "Mercy Stroke", 27 => "Mandalic Stab", 28 => "Mordant Rime", 29 => "Pyrrhic Kleos", 31 => "Rudra's Storm", 43 => "Knights of Round", 44 => "Death Blossom", 45 => "Atonement", 46 => "Expiacion", 57 => "Scourge", 59 => "Torcleaver", 73 => "Onslaught", 74 => "Primal Rend", 76 => "Cloudsplitter", 89 => "Metatron Torment", 90 => "King's Justice", 92 => "Ukko's Fury", 105 => "Catastrophe", 106 => "Insurgency", 108 => "Quietus", 121 => "Geirskogul", 122 => "Drakesbane", 124 => "Camlann's Torment", 137 => "Blade: Metsu", 138 => "Blade: Kamu", 140 => "Blade: Hi", 153 => "Tachi: Kaiten", 154 => "Tachi: Rana", 156 => "Tachi: Fudo", 170 => "Randgrith", 171 => "Mystic Boon", 173 => "Dagan", 185 => "Gate of Tartarus", 186 => "Vidohunir", 187 => "Garland of Bliss", 188 => "Omniscience", 190 => "Myrkr", 200 => "Namas Arrow", 202 => "Jishnu's Radiance", 216 => "Coronach", 217 => "Trueflight", 218 => "Leaden Salute", 220 => "Wildfire", 225 => "Chant du Cygne");
$spikes = array(10 => "Death", 5 => "Shock", 4 => "Curse", 2 => "Ice", 1 => "Blaze");
$slots = array(1 => "Main", 2 => "Sub", 3 => "Main", 4 => "Ranged", 8 => "Ammo", 16 => "Head", 32 => "Body", 64 => "Hands", 128 => "Legs", 256 => "Feet", 512 => "Neck", 1024 => "Waist", 6144 => "Ear", 24576 => "Ring", 32768 => "Back");
$rslots = array(0 => "None", 2 => "Ranged", 3 => "Ammo", 16 => "Head", 8 => "Foot", 6 => "Hand", 4 => "Head");
$ITEM_FLAG_EX = 0x4000;
$ITEM_FLAG_RARE = 0x8000;
if (isset($_GET['id'])) {
  $itemid = $_GET['id'];
  $compiled["itemid"] = $itemid;
  //$itemname = str_replace("_", " ", sqlQuery("SELECT name FROM `item_basic` WHERE itemid = ".$itemid)["name"]);
  //$itemname = mb_eregi_replace('\bM{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})\b', "strtoupper('\\0')", $itemname, 'e');
  //$itemname = ucwords($itemname);
  //$itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));

  // item information
  //$compiled["name"] = $itemname;
  $realname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$itemid)["realname"]);
  $realname = str_replace("The", "the", str_replace("Of", "of", $realname));
  $compiled["realname"] = $realname;
  $sortname = sqlQuery("SELECT sortname FROM `item_info` WHERE itemid = ".$itemid)["sortname"];
  $compiled["sortname"] = $sortname;
  $description = sqlQuery("SELECT description FROM `item_info` WHERE itemid = ".$itemid)["description"];
  $description = str_replace("\n\n", "<br/><br/>", $description);
  $description = str_replace("\n", " ", $description);
  $compiled["description"] = $description;
  $flags = sqlQuery("SELECT flags FROM `item_basic` WHERE itemid = ".$itemid)["flags"];
  $ex = false;
  $rare = false;
  if ($flags & $ITEM_FLAG_EX) {
    $ex = true;
  }
  if ($flags & $ITEM_FLAG_RARE) {
    $rare = true;
  }
  $compiled["ex"] = $ex;
  $compiled["rare"] = $rare;
  $armor = sqlQuery("SELECT jobs, level from `item_armor` WHERE itemId = ".$itemid);
  // is item armor/weapon
  if (!$armor == null) {
    $compiled["armor"] = 1;
    $itemjobs = "";
    for ($i = 1; $i < 23; $i++) {
      if ($armor["jobs"] & (1 << ($i - 1))) {
        if ($itemjobs == "") {
          $itemjobs .= $jobs[$i];
        } else {
          $itemjobs .= " ".$jobs[$i];
        }
      }
    }
    if ($itemjobs == "WAR MNK WHM BLM RDM THF PLD DRK BST BRD RNG SAM NIN DRG SMN BLU COR PUP DNC SCH GEO RUN")
      $itemjobs = "All Jobs";
    $compiled["level"] = $armor["level"];
    $compiled["jobs"] = $itemjobs;
    // item slot
    $slot = $slots[sqlQuery("SELECT slot FROM `item_armor` WHERE itemid = ".$itemid)["slot"]];
    $rslot = sqlQuery("SELECT rslot FROM `item_armor` WHERE itemid = ".$itemid)["rslot"];
    //echo "{".$rslot."}\n\n";
    if ($rslot != 0)
      $rslot_name = $rslots[$rslot];
    else
      $rslot_name = "";
    $compiled["rslot"] = $rslot;
    // item mods
    $mods = ""; $weaponskill = "";
    $gmitem = false;
    $itemaugkiller = false;
    $s_sleep = ""; $s_poison = ""; $s_paralyze = ""; $s_blind = ""; $s_silence = ""; $s_virus = ""; $s_curse = ""; $s_petrify = ""; $s_bind = ""; $s_gravity = ""; $s_stun = ""; $s_slow = ""; $s_charm = ""; $s_amnesia = ""; $s_lullaby = "";
    $dw_fire = ""; $dw_earth = ""; $dw_water = ""; $dw_wind = ""; $dw_ice = ""; $dw_lightning = ""; $dw_light = ""; $dw_dark = "";

    $weapon = sqlQuery("SELECT * FROM `item_weapon` WHERE itemid = ".$itemid);
    $weapon_mods = "";
    if ($weapon != null) {
      $itemdelay = $weapon["delay"];
      $itemdmg = $weapon["dmg"];
      $itemhit = $weapon["hit"];
      $itemskill = $skill[$weapon["skill"]];
      $compiled["itemskill"] = $itemskill;
      $weapon_mods .= "<span class=\"stat\">DPS: ".round(($itemdmg * 60 / ($itemdelay) * 100), 2)."</span>".$space."<span class=\"stat\">DMG:".$itemdmg."</span>".$space."<span class=\"stat\">Delay:".$itemdelay."</span>";
    }
    $mods .= "<span class=\"stat\">[".$slot."] All Races</span><br/>";
    if ($rslot > 0 && $rslot != 3 && $rslot != 2)
      $mods .= "<span class=\"stat\">Cannot equip ".$rslot_name."gear</span><br/>";
    $mods .= $weapon_mods;

    $sqlmod = "SELECT * FROM `item_mods` WHERE itemid = ".$itemid." ORDER BY `item_mods`.`modId` ASC";
    $tmp = mysqli_query($dcon, $sqlmod);
    while($row = $tmp->fetch_assoc()) {
      $tmpadd = "";
      if ($row["value"] > 0)
        $tmpadd = "+";
      switch ($row["modId"]) {
        case 1:
          $mods .= $space."<span class=\"stat\">DEF:".$row["value"]."</span>";
          break;
        case 2:
          $mods .= $space."<span class=\"stat\">HP".$tmpadd.$row["value"]."</span>";
          break;
        case 3:
          $mods .= $space."<span class=\"stat\">HP".$tmpadd.$row["value"]."%</span>";
          break;
        case 4:
          $mods .= $space."<span class=\"stat\">Converts ".$row["value"]." MP to HP</span>";
          break;
        case 5:
          $mods .= $space."<span class=\"stat\">MP".$tmpadd.$row["value"]."</span>";
          break;
        case 6:
          $mods .= $space."<span class=\"stat\">MP".$tmpadd.$row["value"]."%</span>";
          break;
        case 7:
          $mods .= $space."<span class=\"stat\">Converts ".$row["value"]." HP to MP</span>";
          break;
        case 8:
          $mods .= $space."<span class=\"stat\">STR".$tmpadd.$row["value"]."</span>";
          break;
        case 9:
          $mods .= $space."<span class=\"stat\">DEX".$tmpadd.$row["value"]."</span>";
          break;
        case 10:
          $mods .= $space."<span class=\"stat\">VIT".$tmpadd.$row["value"]."</span>";
          break;
        case 11:
          $mods .= $space."<span class=\"stat\">AGI".$tmpadd.$row["value"]."</span>";
          break;
        case 12:
          $mods .= $space."<span class=\"stat\">INT".$tmpadd.$row["value"]."</span>";
          break;
        case 13:
          $mods .= $space."<span class=\"stat\">MND".$tmpadd.$row["value"]."</span>";
          break;
        case 14:
          $mods .= $space."<span class=\"stat\">CHR".$tmpadd.$row["value"]."</span>";
          break;
        case 15:
          $mods .= $space."<span class=\"stat\">[Element: Fire]".$tmpadd.$row["value"]."</span>";
          break;
        case 16:
          $mods .= $space."<span class=\"stat\">[Element: Ice]".$tmpadd.$row["value"]."</span>";
          break;
        case 17:
          $mods .= $space."<span class=\"stat\">[Element: Wind]".$tmpadd.$row["value"]."</span>";
          break;
        case 18:
          $mods .= $space."<span class=\"stat\">[Element: Earth]".$tmpadd.$row["value"]."</span>";
          break;
        case 19:
          $mods .= $space."<span class=\"stat\">[Element: Lightning]".$tmpadd.$row["value"]."</span>";
          break;
        case 20:
          $mods .= $space."<span class=\"stat\">[Element: Water]".$tmpadd.$row["value"]."</span>";
          break;
        case 21:
          $mods .= $space."<span class=\"stat\">[Element: Light]".$tmpadd.$row["value"]."</span>";
          break;
        case 22:
          $mods .= $space."<span class=\"stat\">[Element: Dark]".$tmpadd.$row["value"]."</span>";
          break;
        case 23:
          $mods .= $space."<span class=\"stat\">Attack".$tmpadd.$row["value"]."</span>";
          break;
        case 24:
          $mods .= $space."<span class=\"stat\">Ranged Attack".$tmpadd.$row["value"]."</span>";
          break;
        case 25:
          $mods .= $space."<span class=\"stat\">Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 26:
          $mods .= $space."<span class=\"stat\">Ranged Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 27:
          $mods .= $space."<span class=\"stat\">Enmity".$tmpadd.$row["value"]."</span>";
          break;
        case 28:
          $mods .= $space."<span class=\"stat\">\"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 29:
          $mods .= $space."<span class=\"stat\">\"Magic Def. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 30:
          $mods .= $space."<span class=\"stat\">Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 31:
          $mods .= $space."<span class=\"stat\">Magic Evasion".$tmpadd.$row["value"]."</span>";
          break;
        case 32:
          $mods .= $space."<span class=\"stat\">Fire elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 33:
          $mods .= $space."<span class=\"stat\">Ice elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 34:
          $mods .= $space."<span class=\"stat\">Wind elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 35:
          $mods .= $space."<span class=\"stat\">Earth elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 36:
          $mods .= $space."<span class=\"stat\">Thunder elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 37:
          $mods .= $space."<span class=\"stat\">Water elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 38:
          $mods .= $space."<span class=\"stat\">Light elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 39:
          $mods .= $space."<span class=\"stat\">Dark elemental \"Magic Atk. Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 40:
          $mods .= $space."<span class=\"stat\">Fire elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 41:
          $mods .= $space."<span class=\"stat\">Ice elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 42:
          $mods .= $space."<span class=\"stat\">Wind elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 43:
          $mods .= $space."<span class=\"stat\">Earth elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 44:
          $mods .= $space."<span class=\"stat\">Thunder elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 45:
          $mods .= $space."<span class=\"stat\">Water elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 46:
          $mods .= $space."<span class=\"stat\">Light elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 47:
          $mods .= $space."<span class=\"stat\">Dark elemental Magic Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 48:
          $mods .= $space."<span class=\"stat\">Weapon Skill Accuracy".$tmpadd.$row["value"]."</span>";
          break;
        case 49:
        case 50:
        case 51:
        case 52:
          break;
        case 54:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_fire.png\" />".$tmpadd.$row["value"]."</span>";
          break;        
        case 55:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_ice.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 56:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_wind.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 57:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_earth.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 58:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_lightning.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 59:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_water.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 60:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_light.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 61:
          $mods .= $space."<span class=\"stat\"><img class=\"i_statsicon\" src=\"images/icons/ws_dark.png\" />".$tmpadd.$row["value"]."</span>";
          break;
        case 62:
          $mods .= $space."<span class=\"stat\">Attack".$tmpadd.$row["value"]."%</span>";
          break;
        case 63:
          // Defense %
        case 64:
        case 65:
          break;
        case 66:
          $mods .= $space."<span class=\"stat\">Ranged Attack".$tmpadd.$row["value"]."%</span>";
          break;
        case 67:
          break;
        case 68:
          $mods .= $space."<span class=\"stat\">Evasion".$tmpadd.$row["value"]."</span>";
          break;
        case 69:
          // Ranged Defense
        case 70:
          // Ranged Evasion
          break;
        case 71:
          $mods .= $space."<span class=\"stat\">MP recovered while healing ".$tmpadd.$row["value"]."</span>";
          break;
        case 72:
          $mods .= $space."<span class=\"stat\">HP recovered while healing ".$tmpadd.$row["value"]."</span>";
          break;
        case 73:
        case 486:
          $mods .= $space."<span class=\"stat\">\"Store TP\"".$tmpadd.$row["value"]."</span>";
          break;
        case 487:
          $mods .= $space."<span class=\"stat\">Bonus damage added to magic burst</span>";
          break;
        case 488:
          // Inhibits TP Gain (percent)
          break;
        case 80:
          $mods .= $space."<span class=\"stat\">Hand-to-Hand skill".$tmpadd.$row["value"]."</span>";
          break;
        case 81:
          $mods .= $space."<span class=\"stat\">Dagger skill".$tmpadd.$row["value"]."</span>";
          break;
        case 82:
          $mods .= $space."<span class=\"stat\">Sword skill".$tmpadd.$row["value"]."</span>";
          break;
        case 83:
          $mods .= $space."<span class=\"stat\">Great Sword skill".$tmpadd.$row["value"]."</span>";
          break;
        case 84:
          $mods .= $space."<span class=\"stat\">Axe skill".$tmpadd.$row["value"]."</span>";
          break;
        case 85:
          $mods .= $space."<span class=\"stat\">Great Axe skill".$tmpadd.$row["value"]."</span>";
          break;
        case 86:
          $mods .= $space."<span class=\"stat\">Scythe skill".$tmpadd.$row["value"]."</span>";
          break;
        case 87:
          $mods .= $space."<span class=\"stat\">Polearm skill".$tmpadd.$row["value"]."</span>";
          break;
        case 88:
          $mods .= $space."<span class=\"stat\">Katana skill".$tmpadd.$row["value"]."</span>";
          break;
        case 89:
          $mods .= $space."<span class=\"stat\">Great Katana skill".$tmpadd.$row["value"]."</span>";
          break;
        case 90:
          $mods .= $space."<span class=\"stat\">Club skill".$tmpadd.$row["value"]."</span>";
          break;
        case 91:
          $mods .= $space."<span class=\"stat\">Staff skill".$tmpadd.$row["value"]."</span>";
          break;
        case 101:
        case 102:
        case 103:
          // Automaton Skills
          break;
        case 104:
          $mods .= $space."<span class=\"stat\">Archery skill".$tmpadd.$row["value"]."</span>";
          break;
        case 105:
          $mods .= $space."<span class=\"stat\">Marksmanship skill".$tmpadd.$row["value"]."</span>";
          break;
        case 106:
          $mods .= $space."<span class=\"stat\">Throwing skill".$tmpadd.$row["value"]."</span>";
          break;
        case 107:
          $mods .= $space."<span class=\"stat\">Guard skill".$tmpadd.$row["value"]."</span>";
          break;
        case 108:
          $mods .= $space."<span class=\"stat\">Evasion skill".$tmpadd.$row["value"]."</span>";
          break;
        case 109:
          $mods .= $space."<span class=\"stat\">Shield skill".$tmpadd.$row["value"]."</span>";
          break;
        case 110:
          $mods .= $space."<span class=\"stat\">Parrying skill".$tmpadd.$row["value"]."</span>";
          break;
        case 111:
          $mods .= $space."<span class=\"stat\">Divine magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 112:
          $mods .= $space."<span class=\"stat\">Healing magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 113:
          $mods .= $space."<span class=\"stat\">Enhancing magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 114:
          $mods .= $space."<span class=\"stat\">Enfeebling magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 115:
          $mods .= $space."<span class=\"stat\">Elemental magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 116:
          $mods .= $space."<span class=\"stat\">Dark magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 117:
          $mods .= $space."<span class=\"stat\">Summoning magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 118:
          $mods .= $space."<span class=\"stat\">Ninjutsu skill".$tmpadd.$row["value"]."</span>";
          break;
        case 119:
          $mods .= $space."<span class=\"stat\">Singing skill".$tmpadd.$row["value"]."</span>";
          break;
        case 120:
          $mods .= $space."<span class=\"stat\">String skill".$tmpadd.$row["value"]."</span>";
          break;
        case 121:
          $mods .= $space."<span class=\"stat\">Wind skill".$tmpadd.$row["value"]."</span>";
          break;
        case 122:
          $mods .= $space."<span class=\"stat\">Blue magic skill".$tmpadd.$row["value"]."</span>";
          break;
        case 127:
          $mods .= $space."<span class=\"stat\">Fishing skill".$tmpadd.$row["value"]."</span>";
          break;
        case 128:
          $mods .= $space."<span class=\"stat\">Woodworking skill".$tmpadd.$row["value"]."</span>";
          break;
        case 129:
          $mods .= $space."<span class=\"stat\">Smithing skill".$tmpadd.$row["value"]."</span>";
          break;
        case 130:
          $mods .= $space."<span class=\"stat\">Goldsmithing skill".$tmpadd.$row["value"]."</span>";
          break;
        case 131:
          $mods .= $space."<span class=\"stat\">Clothcraft skill".$tmpadd.$row["value"]."</span>";
          break;
        case 132:
          $mods .= $space."<span class=\"stat\">Leathercraft skill".$tmpadd.$row["value"]."</span>";
          break;
        case 133:
          $mods .= $space."<span class=\"stat\">Bonecraft skill".$tmpadd.$row["value"]."</span>";
          break;
        case 134:
          $mods .= $space."<span class=\"stat\">Alchemy skill".$tmpadd.$row["value"]."</span>";
          break;
        case 135:
          $mods .= $space."<span class=\"stat\">Cooking skill".$tmpadd.$row["value"]."</span>";
          break;
        case 136:
          $mods .= $space."<span class=\"stat\">Synergy skill".$tmpadd.$row["value"]."</span>";
          break;
        case 137:
          $mods .= $space."<span class=\"stat\">Riding skill".$tmpadd.$row["value"]."</span>";
          break;
        case 144:
          $mods .= $space."<span class=\"stat\">Woodworking Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 145:
          $mods .= $space."<span class=\"stat\">Smithing Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 146:
          $mods .= $space."<span class=\"stat\">Goldsmithing Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 147:
          $mods .= $space."<span class=\"stat\">Clothcraft Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 148:
          $mods .= $space."<span class=\"stat\">Leathercraft Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 149:
          $mods .= $space."<span class=\"stat\">Bonecraft Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 150:
          $mods .= $space."<span class=\"stat\">Alchemy Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 151:
          $mods .= $space."<span class=\"stat\">Cooking Success Rate".$tmpadd.$row["value"]."%</span>";
          break;
        case 160:
          $mods .= $space."<span class=\"stat\">Damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 161:
          $mods .= $space."<span class=\"stat\">Physical damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 162:
          $mods .= $space."<span class=\"stat\">Breath damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 163:
          $mods .= $space."<span class=\"stat\">Magic damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 831:
          $mods .= $space."<span class=\"stat\">Magic damage taken II ".$tmpadd.$row["value"]."%</span>";
          break;
        case 164:
          $mods .= $space."<span class=\"stat\">Ranged damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 387:
        case 388:
        case 389:
        case 390:
          // GM Ring
          $gmitem = true;
          break;
        case 165:
          $mods .= $space."<span class=\"stat\">Critical hit rate ".$tmpadd.$row["value"]."%</span>";
          break;
        case 421:
          $mods .= $space."<span class=\"stat\">Increases critical hit damage</span>";
          break;
        case 166:
          $mods .= $space."<span class=\"stat\">Enemy critical hit rate ".$tmpadd.$row["value"]."%</span>";
          break;
        case 562:
          $mods .= $space."<span class=\"stat\">Magic critical hit rate ".$tmpadd.$row["value"]."%</span>";
          break;
        case 563:
          $mods .= $space."<span class=\"stat\">Increases magic critical hit damage</span>";
          break;
        case 167:
        case 384:
          $mods .= $space."<span class=\"stat\">Haste ".$tmpadd.round(($row["value"] / 10), 1)."%</span>";
          break;
        case 168:
          $mods .= $space."<span class=\"stat\">Spell interruption rate down ".$tmpadd.$row["value"]."%</span>";
          break;
        case 169:
          $mods .= $space."<span class=\"stat\">Movement speed ".$tmpadd.$row["value"]."%</span>";
          break;
        case 170:
          $mods .= $space."<span class=\"stat\">Enhances \"Fast Cast\" effect</span>";
          break;
        case 407:
          $mods .= $space."<span class=\"stat\">\"Fast Cast\"".$tmpadd.$row["value"]."%</span>";
          break;
        case 519:
        case 394:
        case 396:
          $mods .= $space."<span class=\"stat\">\"Cure\" spellcasting time -".abs($row["value"])."%</span>";
          break;
        case 171:
          $mods .= $space."<span class=\"stat\">Two-handed weapon delay ".$tmpadd.$row["value"]."%</span>";
          break;
        case 173:
          $mods .= $space."<span class=\"stat\">Enhances \"Martial Arts\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 174:
          $mods .= $space."<span class=\"stat\">\"Skillchain Bonus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 311:
          $mods .= $space."<span class=\"stat\">Magic Damage".$tmpadd.$row["value"]."</span>";
          break;
        case 224:
        case 225:
        case 226:
        case 227:
        case 228:
        case 229:
        case 230:
        case 231:
        case 232:
        case 233:
        case 234:
        case 235:
        case 236:
        case 237:
        case 238:
          $itemaugkiller = true;
          break;
        case 240:
          $s_sleep = $space."<span class=\"stat\">Enhances \"Resist Sleep\" effect</span>";
          break;
        case 241:
          $s_poison .= $space."<span class=\"stat\">Enhances \"Resist Poison\" effect</span>";
          break;
        case 242:
          $s_paralyze .= $space."<span class=\"stat\">Enhances \"Resist Paralyze\" effect</span>";
          break;
        case 243:
          $s_blind .= $space."<span class=\"stat\">Enhances \"Resist Blind\" effect</span>";
          break;
        case 244:
          $s_silence .= $space."<span class=\"stat\">Enhances \"Resist Silence\" effect</span>";
          break;
        case 245:
          $s_virus .= $space."<span class=\"stat\">Enhances \"Resist Virus\" effect</span>";
          break;
        case 246:
          $s_petrify .= $space."<span class=\"stat\">Enhances \"Resist Petrify\" effect</span>";
          break;
        case 247:
          $s_bind .= $space."<span class=\"stat\">Enhances \"Resist Bind\" effect</span>";
          break;
        case 248:
          $s_curse .= $space."<span class=\"stat\">Enhances \"Resist Curse\" effect</span>";
          break;
        case 249:
          $s_gravity .= $space."<span class=\"stat\">Enhances \"Resist Gravity\" effect</span>";
          break;
        case 250:
          $s_slow .= $space."<span class=\"stat\">Enhances \"Resist Slow\" effect</span>";
          break;
        case 251:
          $s_stun .= $space."<span class=\"stat\">Enhances \"Resist Stun\" effect</span>";
          break;
        case 252:
          $s_charm .= $space."<span class=\"stat\">Enhances \"Resist Charm\" effect</span>";
          break;
        case 253:
          $s_amnesia .= $space."<span class=\"stat\">Enhances \"Resist Amnesia\" effect</span>";
          break;
        case 254:
          $s_lullaby .= $space."<span class=\"stat\">Enhances \"Resist Lullaby\" effect</span>";
          break;
        case 255:
          $mods .= $space."<span class=\"stat\">Enhances resistance against \"Death\"</span>";
          break;
        case 259:
          $mods .= $space."<span class=\"stat\">Enhances \"Dual Wield\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 288:
          $mods .= $space."<span class=\"stat\">\"Double Attack\"".$tmpadd.$row["value"]."%</span>";
          break;
        case 483:
          $mods .= $space."<span class=\"stat\">Enhances \"Warcry\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 97:
          $mods .= $space."<span class=\"stat\">Enhances \"Boost\" effect ".$tmpadd.round(($row["value"] / 10), 1)."%</span>";
          break;
        case 289:
          $mods .= $space."<span class=\"stat\">\"Subtle Blow\"".$tmpadd.$row["value"]."</span>";
          break;
        case 291:
          $mods .= $space."<span class=\"stat\">\"Counter\"".$tmpadd.$row["value"]."</span>";
          break;
        case 292:
          $mods .= $space."<span class=\"stat\">\"Kick Attacks\"".$tmpadd.$row["value"]."</span>";
          break;
        case 428:
          $mods .= $space."<span class=\"stat\">Increases \"Perfect Counter\" attack ".$tmpadd.$row["value"]."</span>";
          break;
        case 429:
          $mods .= $space."<span class=\"stat\">Enhances \"Footwork\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 543:
          $mods .= $space."<span class=\"stat\">Enhances \"Counterstance\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 552:
          $mods .= $space."<span class=\"stat\">Enhances \"Dodge\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 561:
          $mods .= $space."<span class=\"stat\">Enhances \"Focus\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 484:
          $mods .= $space."<span class=\"stat\">Enhances \"Auspice\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 524:
          $mods .= $space."<span class=\"stat\">Enhances \"Divine Veil\" effect</span>";
          break;
        case 838:
          $mods .= $space."<span class=\"stat\">Enhances \"Regen\" potency ".$tmpadd.$row["value"]."%</span>";
          break;
        case 296:
          $mods .= $space."<span class=\"stat\">\"Conserve MP\" ".$tmpadd.$row["value"]."%</span>";
          break;
        case 300:
          if ($row["value"] < 0) {
            $mods .= $space."<span class=\"stat\">\"Stoneskin\" casting time ".$tmpadd.$row["value"]."%</span>";
          } else {
            $mods .= $space."<span class=\"stat\">Enhances \"Stoneskin\" effect ".$tmpadd.$row["value"]."%</span>";
          }
          break;
        case 93:
          $mods .= $space."<span class=\"stat\">Increases \"Flee\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 298:
          $mods .= $space."<span class=\"stat\">\"Steal\"".$tmpadd.$row["value"]."</span>";
          break;
        case 302:
          $mods .= $space."<span class=\"stat\">\"Triple Attack\"".$tmpadd.$row["value"]."%</span>";
          break;
        case 303:
          $mods .= $space."<span class=\"stat\">\"Treasure Hunter\"".$tmpadd.$row["value"]."</span>";
          break;
        case 520:
          $mods .= $space."<span class=\"stat\">Increases \"Trick Attack\" damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 835:
          $mods .= $space."<span class=\"stat\">Enhances \"Mug\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 92:
          $mods .= $space."<span class=\"stat\">Increases \"Rampart\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 426:
        case 516:
          $mods .= $space."<span class=\"stat\">Converts ".$row["value"]."% of physical damage taken to MP</span>";
          break;
        case 427:
          $mods .= $space."<span class=\"stat\">Reduces Enmity decrease when taking damage -".abs($row["value"])."</span>";
          break;
        case 837:
          $mods .= $space."<span class=\"stat\">Enhances \"Sentinel\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 96:
          $mods .= $space."<span class=\"stat\">Enhances \"Souleater\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 304:
        case 391:
          $mods .= $space."<span class=\"stat\">\"Charm\" ".$tmpadd.$row["value"]."%</span>";
          break;
        case 360:
          $mods .= $space."<span class=\"stat\">Increases \"Charm\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 364:
          $mods .= $space."<span class=\"stat\">Enhances \"Reward\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 564:
          $mods .= $space."<span class=\"stat\">Augments \"Call Beast\" ".$tmpadd.$row["value"]."</span>";
          break;
        case 433:
          $mods .= $space."<span class=\"stat\">\"Minne\"".$tmpadd.$row["value"]."</span>";
          break;
        case 434:
          $mods .= $space."<span class=\"stat\">\"Minuet\"".$tmpadd.$row["value"]."</span>";
          break;
        case 435:
          $mods .= $space."<span class=\"stat\">\"Paeon\"".$tmpadd.$row["value"]."</span>";
          break;
        case 436:
          $mods .= $space."<span class=\"stat\">\"Requiem\"".$tmpadd.$row["value"]."</span>";
          break;
        case 437:
          $mods .= $space."<span class=\"stat\">\"Threnody\"".$tmpadd.$row["value"]."</span>";
          break;
        case 438:
          $mods .= $space."<span class=\"stat\">\"Madrigal\"".$tmpadd.$row["value"]."</span>";
          break;
        case 439:
          $mods .= $space."<span class=\"stat\">\"Mambo\"".$tmpadd.$row["value"]."</span>";
          break;
        case 440:
          $mods .= $space."<span class=\"stat\">\"Lullaby\"".$tmpadd.$row["value"]."</span>";
          break;
        case 441:
          $mods .= $space."<span class=\"stat\">\"Etude\"".$tmpadd.$row["value"]."</span>";
          break;
        case 442:
          $mods .= $space."<span class=\"stat\">\"Ballad\"".$tmpadd.$row["value"]."</span>";
          break;
        case 443:
          $mods .= $space."<span class=\"stat\">\"March\"".$tmpadd.$row["value"]."</span>";
          break;
        case 444:
          $mods .= $space."<span class=\"stat\">\"Finale\"".$tmpadd.$row["value"]."</span>";
          break;
        case 445:
          $mods .= $space."<span class=\"stat\">\"Carol\"".$tmpadd.$row["value"]."</span>";
          break;
        case 446:
          $mods .= $space."<span class=\"stat\">\"Mazurka\"".$tmpadd.$row["value"]."</span>";
          break;
        case 447:
          $mods .= $space."<span class=\"stat\">\"Elegy\"".$tmpadd.$row["value"]."</span>";
          break;
        case 448:
          $mods .= $space."<span class=\"stat\">\"Prelude\"".$tmpadd.$row["value"]."</span>";
          break;
        case 449:
          $mods .= $space."<span class=\"stat\">\"Hymnus\"".$tmpadd.$row["value"]."</span>";
          break;
        case 450:
          $mods .= $space."<span class=\"stat\">\"Virelai\"".$tmpadd.$row["value"]."</span>";
          break;
        case 451:
          $mods .= $space."<span class=\"stat\">\"Scherzo\"".$tmpadd.$row["value"]."</span>";
          break;
        case 452:
          $mods .= $space."<span class=\"stat\">All songs ".$tmpadd.$row["value"]."</span>";
          break;
        case 453:
          $mods .= $space."<span class=\"stat\">Grants two additional song effects</span>";
          break;
        case 454:
          $mods .= $space."<span class=\"stat\">Increases song effect duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 455:
          $mods .= $space."<span class=\"stat\">Song spellcasting time -".abs($row["value"])."%</span>";
          break;
        case 833:
          $mods .= $space."<span class=\"stat\">Song recast delay -".abs($row["value"] / 1000)."</span>";
          break;
        case 98:
          $mods .= $space."<span class=\"stat\">Enhances \"Camouflage\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 305:
          $mods .= $space."<span class=\"stat\">\"Recycle\"".$tmpadd.$row["value"]."%</span>";
          break;
        case 365:
        case 314:
          $mods .= $space."<span class=\"stat\">Enhances \"Snapshot\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 359:
          $mods .= $space."<span class=\"stat\">Increases \"Rapid Shot\" activation rate ".$tmpadd.$row["value"]."%</span>";
          break;
        case 420:
          $mods .= $space."<span class=\"stat\">Increases \"Barrage\" accuracy ".$tmpadd.$row["value"]."</span>";
          break;
        case 422:
          $mods .= $space."<span class=\"stat\">Enhances \"Double Shot\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 423:
          $mods .= $space."<span class=\"stat\">Enhances \"Velocity Shot\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 425:
          $mods .= $space."<span class=\"stat\">Increases \"Shadowbind\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 312:
          $mods .= $space."<span class=\"stat\">Enhances \"Scavange\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 94:
          $mods .= $space."<span class=\"stat\">Increases \"Meditate\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 95:
          $mods .= $space."<span class=\"stat\">Increases \"Warding Circle\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 306:
          $mods .= $space."<span class=\"stat\">Enhances \"Zanshin\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 308:
          $mods .= $space."<span class=\"stat\">\"Ninja tool expertise\" ".$tmpadd.$row["value"]."%</span>";
          break;
        case 522:
          $mods .= $space."<span class=\"stat\">Enhances ninjutsu damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 361:
          $mods .= $space."<span class=\"stat\">\"Jump\" TP Bonus ".$tmpadd.$row["value"]."</span>";
          break;
        case 362:
          $mods .= $space."<span class=\"stat\">\"Jump\" Attack Bonus ".$tmpadd.$row["value"]."%</span>";
          break;
        case 363:
          $mods .= $space."<span class=\"stat\">Enhances \"High Jump\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 828:
          $mods .= $space."<span class=\"stat\">Augments jump attacks</span>";
          break;
        case 829:
          $mods .= $space."<span class=\"stat\">Wyvern uses breaths more effectively</span>";
          break;
        case 371:
          $mods .= $space."<span class=\"stat\">Perpetuation cost -".abs($row["value"])."</span>";
          break;
        case 372:
          $mods .= $space."<span class=\"stat\">Weather: Avatar perpetuation cost -".abs($row["value"])."</span>";
          break;
        case 372:
          $mods .= $space."<span class=\"stat\">Weather: Avatar perpetuation cost -".abs($row["value"])."</span>";
          break;
        case 373:
          $mods .= $space."<span class=\"stat\"><br/><span class=\"stat\">Depending on day or weather:</span><br/><span class=\"stat\">Halves avatar perpetuation cost</span></span>";
          break;
        case 346:
          $mods .= $space."<span class=\"stat\">Avatar perpetuation cost -".abs($row["value"])."</span>";
          break;
        case 357:
          $mods .= $space."<span class=\"stat\">\"Blood Pact\" ability delay -".abs($row["value"])."</span>";
          break;
        case 540:
          $mods .= $space."<span class=\"stat\">Enhances \"Elemental Siphon\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 541:
          $mods .= $space."<span class=\"stat\">\"Blood Pact\" recast time II -".abs($row["value"])."</span>";
          break;
        case 528:
          $mods .= $space."<span class=\"stat\">Increases \"Phantom Roll\" area of effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 411:
          $mods .= $space."<span class=\"stat\">Enhances \"Quick Draw\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 504:
          $mods .= $space."<span class=\"stat\">Enhances \"Maneuver\" effects ".$tmpadd.$row["value"]."</span>";
          break;
        case 505:
          $mods .= $space."<span class=\"stat\">Reduces \"Overload\" rate ".$tmpadd.$row["value"]."%</span>";
          break;
        case 490:
          $mods .= $space."<span class=\"stat\">Increases \"Samba\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 491:
          $mods .= $space."<span class=\"stat\">\"Waltz\" potency ".$tmpadd.$row["value"]."%</span>";
          break;
        case 492:
          $mods .= $space."<span class=\"stat\">Increases \"Jig\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 493:
          $mods .= $space."<span class=\"stat\">\"Violent Flourish\" accuracy ".$tmpadd.$row["value"]."</span>";
          break;
        case 494:
          if ($row["value"] == 20) {
            $mods .= $space."<span class=\"stat\">Enhances \"Violent Flourish\" effects ".$tmpadd.$row["value"]."</span>";
          } else {
            $mods .= $space."<span class=\"stat\">Increases \"Steps\" accuracy ".$tmpadd.$row["value"]."</span>";
            $mods .= $space."<span class=\"stat\">Augments \"Steps\"</span>";
          }
          break;
        case 403:
          $mods .= $space."<span class=\"stat\">Increases \"Steps\" accuracy ".$tmpadd.$row["value"]."</span>";
          break;
        case 498:
          $mods .= $space."<span class=\"stat\">Increases \"Samba\" duration ".$tmpadd.$row["value"]."%</span>";
          break;
        case 836:
          $mods .= $space."<span class=\"stat\">\"Reverse Flourish\"".$tmpadd.$row["value"]."</span>";
          break;
        case 395:
          $mods .= $space."<span class=\"stat\">Black magic casting time -".abs($row["value"])."%</span>";
          break;
        case 399:
          $mods .= $space."<span class=\"stat\">Enhances \"Celerity\" and \"Alacrity\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 334:
          $mods .= $space."<span class=\"stat\">Enhances \"Light Arts\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 335:
          $mods .= $space."<span class=\"stat\">Enhances \"Dark Arts\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 336:
          $mods .= $space."<span class=\"stat\">Enhances \"Addendum: White\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 337:
          $mods .= $space."<span class=\"stat\">Enhances \"Addendum: Black\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 339:
          $mods .= $space."<span class=\"stat\">Increases \"Regen\" duration ".$tmpadd.$row["value"]."</span>";
          break;
        case 401:
          $mods .= $space."<span class=\"stat\">Enhances \"Sublimation\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 489:
          $mods .= $space."<span class=\"stat\">Grimoire: Reduces spellcasting time -".abs($row["value"])."%</span>";
          break;
        case 432:
          $mods .= $space."<span class=\"stat\">Sword enhancement spell damage ".$tmpadd.$row["value"]."</span>";
          break;
        case 344:
          $mods .= $space."<span class=\"stat\">\"Spikes\" spell damage ".$tmpadd.$row["value"]."</span>";
          break;
        case 345:
          $mods .= $space."<span class=\"stat\">\"Conserve TP\"".$tmpadd.$row["value"]."</span>";
          break;
        case 355:
          $weaponskill .= $space."<span class=\"stat\">\"".$ws[$row["value"]]."\"</span>";
          break;
        case 356:
          $mods .= $space."<span class=\"stat\">In Dynamis: \"".$ws[$row["value"]]."\"</span>";
          break;
        case 366:
          $mods .= $space."<span class=\"stat\">Main hand: DMG:".($itemdmg + $row["value"])."</span>";
          break;
        case 368:
          $mods .= $space."<span class=\"stat\">\"Regain\"".$tmpadd.$row["value"]."</span>";
          break;
        case 369:
          $mods .= $space."<span class=\"stat\">Adds \"Refresh\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 370:
          $mods .= $space."<span class=\"stat\">Adds \"Regen\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 374:
          $mods .= $space."<span class=\"stat\">\"Cure\" potency ".$tmpadd.$row["value"]."%</span>";
          break;
        case 375:
          $mods .= $space."<span class=\"stat\">Potency of \"Cure\" effect received ".$tmpadd.$row["value"]."%</span>";
          break;
        case 377:
        case 378:
        case 379:
          $mods .= $space."<span class=\"stat\">Latent effect: DMG:".($itemdmg + $row["value"])."</span>";
          break;
        case 385:
          if ($row["value"] > 200) {
            $mods .= $space."<span class=\"stat\">\"Shield Bash\" ".romanic_number(substr($row["value"], 1, 1) + 1)."</span>";
          } else {
            $mods .= $space."<span class=\"stat\">\"Shield Bash\"".$tmpadd.$row["value"]."</span>";
          }
          break;
        case 386:
        case 482:
          $mods .= $space."<span class=\"stat\">\"Kick Attacks\"".$tmpadd.$row["value"]."</span>";
          break;
        case 392:
          $mods .= $space."<span class=\"stat\">\"Weapon Bash\"".$tmpadd.$row["value"]."</span>";
          break;
        case 402:
          $mods .= $space."<span class=\"stat\">Enhances effect of wyvern's breath ".$tmpadd.$row["value"]."</span>";
          break;
        case 408:
          $mods .= $space."<span class=\"stat\">Increases \"Double Attack\" damage ".$tmpadd.$row["value"]."</span>";
          break;
        case 409:
          $mods .= $space."<span class=\"stat\">\"Triple Attack\" damage ".$tmpadd.$row["value"]."</span>";
          break;
        case 480:
          $mods .= $space."<span class=\"stat\">Absorbs magic damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 416:
          $mods .= $space."<span class=\"stat\">Occasionally annuls damage from physical attacks ".$tmpadd.$row["value"]."%</span>";
          break;
        case 430:
          $mods .= $space."<span class=\"stat\">\"Quadruple Attack\"".$tmpadd.$row["value"]."%</span>";
          break;
        case 459:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs fire damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 460:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs earth damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 461:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs water damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 462:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs wind damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 463:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs ice damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 464:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs lightning damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 465:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs light damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 466:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs dark damage ".$tmpadd.$row["value"]."%</span>";
          break;
        case 475:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs magic damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 476:
          $mods .= $space."<span class=\"stat\">Occasionally annuls magic damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 512:
          $mods .= $space."<span class=\"stat\">Occasionally absorbs physical damage taken ".$tmpadd.$row["value"]."%</span>";
          break;
        case 431:
          // Additional Effect: *
          break;
        case 499:
          $mods .= $space."<span class=\"stat\">Physical damage: \"".$spikes[$row["value"]]." Spikes\" effect</span>";
          break;
        case 310:
          $mods .= $space."<span class=\"stat\">Enhances \"Cursna\" effect ".$tmpadd.$row["value"]."%</span>";
          break;
        case 414:
          $mods .= $space."<span class=\"stat\">\"Retaliation\"".$tmpadd.$row["value"]."</span>";
          break;
        case 508:
          $mods .= $space."<span class=\"stat\">\"Third Eye\": \"Counter\" rate ".$tmpadd.$row["value"]."</span>";
          break;
        case 510:
          $mods .= $space."<span class=\"stat\">Reduces clamming \"incidents\"</span>";
          break;
        case 511:
          $mods .= $space."<span class=\"stat\">Extends chocobo riding time ".$tmpadd.$row["value"]."</span>";
          break;
        case 513:
          $mods .= $space."<span class=\"stat\">Improves mining and harvesting results ".$tmpadd.$row["value"];
          if ($row["value"] == 1)
            $mods .= "%";
          $mods .= "</span>";
          break;
        case 514:
          $mods .= $space."<span class=\"stat\">Improves logging and harvesting results ".$tmpadd.$row["value"];
          if ($row["value"] == 1)
            $mods .= "%";
          $mods .= "</span>";
          break;
        case 515:
          $mods .= $space."<span class=\"stat\">Improves mining, logging and harvesting results ".$tmpadd.$row["value"];
          if ($row["value"] == 1)
            $mods .= "%";
          $mods .= "</span>";
          break;
        case 517:
          $mods .= $space."<span class=\"stat\">Chocobo Digging Bonus</span>";
          break;
        case 313:
          $mods .= $space."<span class=\"stat\">Enhances \"Dia\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 315:
          $mods .= $space."<span class=\"stat\">Enhances the effect of \"Dia\" and \"Aspir\" ".$tmpadd.$row["value"]."</span>";
          break;
        case 521:
          $mods .= $space."<span class=\"stat\">Augments \"Absorb\" spells ".romanic_number(substr($row["value"], 0, 1))."</span>";
          break;
        case 826:
          $mods .= $space."<span class=\"stat\">Virtue stone equipped: Occasionally attacks twice</span>";
          break;
        case 525:
          $mods .= $space."<span class=\"stat\">Augments \"Convert\" x".$row["value"]."</span>";
          break;
        case 526:
          $mods .= $space."<span class=\"stat\">Enhances \"Sneak Attack\" effect ".romanic_number(substr($row["value"], 0, 1))."</span>";
          break;
        case 527:
          $mods .= $space."<span class=\"stat\">Enhances \"Trick Attack\" effect ".romanic_number(substr($row["value"], 0, 1))."</span>";
          break;
        case 529:
          $mods .= $space."<span class=\"stat\">Enhances \"Refresh\" potency ".romanic_number(substr($row["value"], 0, 1))."</span>";
          break;
        case 530:
          $mods .= $space."<span class=\"stat\">MP not depleted when magic used  ".$tmpadd.$row["value"]."%</span>";
          break;
        case 531:
          $dw_fire .= $space."<span class=\"stat\">Gain full benefit of Firesday/fire weather bonuses</span>";
          break;
        case 532:
          $dw_earth .= $space."<span class=\"stat\">Gain full benefit of Earthsday/earth weather bonuses</span>";
          break;
        case 533:
          $dw_water .= $space."<span class=\"stat\">Gain full benefit of Watersday/water weather bonuses</span>";
          break;
        case 534:
          $dw_wind .= $space."<span class=\"stat\">Gain full benefit of Windsday/wind weather bonuses</span>";
          break;
        case 535:
          $dw_ice .= $space."<span class=\"stat\">Gain full benefit of Iceday/ice weather bonuses</span>";
          break;
        case 536:
          $dw_lightning .= $space."<span class=\"stat\">Gain full benefit of Lightningday/lightning weather bonuses</span>";
          break;
        case 537:
          $dw_light .= $space."<span class=\"stat\">Gain full benefit of Lightsday/light weather bonuses</span>";
          break;
        case 538:
          $dw_dark .= $space."<span class=\"stat\">Gain full benefit of Darksday/dark weather bonuses</span>";
          break;

        case 527:
          $mods .= $space."<span class=\"stat\">Enhances \"Trick Attack\" effect ".romanic_number(substr($row["value"], 0, 1))."</span>";
          break;
        case 539:
          $mods .= $space."<span class=\"stat\">Enhances \"Stoneskin\" effect ".$tmpadd.$row["value"]."</span>";
          break;
        case 565:
          $mods .= $space."<span class=\"stat\">Elemental magic affected by day ".$tmpadd.$row["value"]."%</span>";
          break;
        case 566:
          $weaponskill .= $space."<span class=\"stat\">\"Iridescence\"</span>";
          break;
        case 567:
          $mods .= $space."<span class=\"stat\">Elemental resistance spells ".$tmpadd.$row["value"]."</span>";
          break;
        case 827:
          $mods .= $space."<span class=\"stat\">Enhances elemental resistance spells ".$tmpadd.$row["value"]."</span>";
          break;
        case 568:
          $mods .= $space."<span class=\"stat\">\"Rapture\"".$tmpadd.$row["value"]."</span>";
          break;
        case 569:
          $mods .= $space."<span class=\"stat\">\"Ebullience\"".$tmpadd.$row["value"]."</span>";
          break;
        case 832:
          $mods .= $space."<span class=\"stat\">Enhances \"Aquaveil\" effect</span>";
          break;
        default:
          break;
      }
    }
    if ($s_sleep != "" && $s_poison != "" && $s_paralyze != "" && $s_blind != "" && $s_silence != "" && $s_curse != "" && $s_virus != "" && $s_petrify != "" && $s_bind != "" && $s_gravity != "" && $s_stun != "" && $s_slow != "" && $s_charm != "")
      $mods .= $space."<span class=\"stat\">Increases resistance to all status ailments</span>";
    else
      $mods .= $s_sleep.$s_poison.$s_paralyze.$s_blind.$s_silence.$s_virus.$s_petrify.$s_bind.$s_gravity.$s_stun.$s_slow.$s_charm.$s_amnesia.$s_lullaby.$s_curse;
    if ($dw_fire != "" && $dw_earth != "" && $dw_water != "" && $dw_wind != "" && $dw_ice != "" && $dw_lightning != "" && $dw_light != "" && $dw_dark != "")
      $mods .= $space."<span class=\"stat\">Gain full benefit of day and weather bonuses </span>";
    else
      $mods .= $dw_fire.$dw_earth.$dw_water.$dw_wind.$dw_ice.$dw_lightning.$dw_light.$dw_dark;
    if ($itemaugkiller)
      $mods .= $space."<span class=\"stat\">Augments \"Killer\" effects</span>";
    if ($gmitem)
      $mods .= $space."GMs Only";
    if ($weapon != null) {
      $mods .= $weaponskill;
      if ($itemhit > 1)
        $mods .= $space."<span class=\"stat\">Occasionally attacks 2 to ".$itemhit." times</span>";
    }
    $compiled["mods"] = $mods;
  } else {
    $compiled["armor"] = 0;
  }
  if (!$tooltip) {
    // auction house - stats
    $compiled["nosale"] = sqlQuery("SELECT NoSale FROM `item_basic` WHERE itemid = ".$itemid)["NoSale"];
    if (!$compiled["nosale"]) {
      $stack = sqlQuery("SELECT stackSize FROM `item_basic` WHERE itemid = ".$itemid)["stackSize"];
      $stacked = 0;
      if (intval($stack) > 1)
        $stacked = 1;
      $price = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$itemid." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = ".$stackSize)["price"];
      if (!isset($price))
        $price = "0";
      $instock = sqlQuery("SELECT COUNT(*) FROM `auction_house` WHERE itemid = ".$itemid." AND seller_name = 'DarkStar' AND buyer_name IS NULL AND stack = ".$stackSize)["COUNT(*)"];
      if ($instock == 0)
        $compiled["instock"] = "<span class=\"red\">".$instock."</span>";
      else if ($instock == 1)
        $compiled["instock"] = "<span class=\"yellow\">".$instock."</span>";
      else
        $compiled["instock"] = "<span class=\"green\">".$instock."</span>";
      $ahcat = intval(sqlQuery("SELECT aH FROM `item_basic` WHERE itemid = ".$itemid)["aH"]);
      $compiled["ahcat"] = getCategory($ahcat);
      $compiled["ahcatid"] = $ahcat;
      $compiled["stack"] = $stack;
      $compiled["price"] = number_format($price);
    }
    if (!$compiled["nosale"]) {
      // bazaar
      $sql = "SELECT charid, quantity, bazaar, signature FROM `char_inventory` WHERE itemid = ".$itemid." AND bazaar > 0 ORDER BY `char_inventory`.`bazaar` DESC";
      $bazaar = array();
      $z = 0;
      $tmp = mysqli_query($dcon, $sql);
      while ($row = $tmp->fetch_assoc()) {
        $bazaar[$z]['charid'] = $row['charid'];
        $charname = sqlQuery("SELECT charname FROM `chars` WHERE charid = ".$row['charid'])['charname'];
        $bazaar[$z]['charname'] = $charname;
        $bazaar[$z]['quantity'] = $row['quantity'];
        $bazaar[$z]['price'] = number_format($row['bazaar']);
        $bazaar[$z]['signature'] = $row['signature'];
        $ahprice = sqlQuery("SELECT sale FROM `auction_house` WHERE seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND itemid = ".$itemid)["sale"];
        $ahprice = $ahprice - $row['bazaar'];
        $bazaar[$z]['ahprice'] = $ahprice;
        $z++;
      }
      $compiled['bazaar'] = $bazaar;

      // auction house
      if (isset($_GET["stack"])) {
        $sql = "SELECT * FROM `auction_house` WHERE itemid = ".$itemid." AND stack = 0 ORDER BY `auction_house`.`sell_date` DESC LIMIT 20";
        if ($_GET["stack"] == 1) {
          $sql = "SELECT * FROM `auction_house` WHERE itemid = ".$itemid." AND stack = 1 ORDER BY `auction_house`.`sell_date` DESC LIMIT 20";
          $realname .= " x12";
        }
        $tmp = mysqli_query($dcon, $sql);
        $ah = array();
        $z = 0;
        while($row = $tmp->fetch_assoc()) {
          if ($row["seller_name"] == "null" or $row["buyer_name"] == null)
            continue;
          if (intval(date("Y",$row["sell_date"])) > 2018)
            continue;
          if ($row["buyer_name"] == "DarkStar")
            $ah[$z]["buyer"] = "AfterHours";
          else
            $ah[$z]["buyer"] = $row["buyer_name"];
          if ($row["seller_name"] == "DarkStar")
            $ah[$z]["seller"] = "AfterHours";
          else
            $ah[$z]["seller"] = $row['seller_name'];
          $ah[$z]["price"] = number_format($row["sale"]);
          //$ah[$z]["date"] = trim(date("m/d/Y h:ia", $row["sell_date"]), "m");
          $timestamp = new DateTime(date("Y-m-d H:i:s",$row['sell_date']));
          $ah[$z]["date"] = trim($timestamp->format("m/d/Y h:ia"), "m");
          $z++;
        }
        $compiled["ah"] = $ah;
      }
    }

    // Recipe
    $count = sqlQuery("SELECT Count(*) FROM `synth_recipes` WHERE `Result` = ".$itemid)["Count(*)"];
    if ($count > 0) {
      $sql = "SELECT * FROM `synth_recipes` WHERE `Result` = ".$itemid;
    } else {
      $sql = "SELECT * FROM `synth_recipes` WHERE `Result` = ".$itemid." OR ResultHQ1 = ".$itemid." OR ResultHQ2 = ".$itemid." OR ResultHQ3 = ".$itemid;
    }
    $tmp = mysqli_query($dcon, $sql);
    $recipe = array();
    $a = 0;

    while($recipesql = $tmp->fetch_assoc()) {
      $recipe[$a]["id"] = $recipesql["ID"];
      $recipe[$a]["alchemy"] = $recipesql["Alchemy"];
      $recipe[$a]["bone"] = $recipesql["Bone"];
      $recipe[$a]["cloth"] = $recipesql["Cloth"];
      $recipe[$a]["cook"] = $recipesql["Cook"];
      $recipe[$a]["gold"] = $recipesql["Gold"];
      $recipe[$a]["leather"] = $recipesql["Leather"];
      $recipe[$a]["smith"] = $recipesql["Smith"];
      $recipe[$a]["wood"] = $recipesql["Wood"];
      $cname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipesql["Crystal"])["realname"]);
      $cname = str_replace("The", "the", str_replace("Of", "of", $cname));
      $rname = $recipesql["Crystal"].":".$cname;
      $recipe[$a]["crystal"] = $rname;
      $ingredients = array();
      $recipesqlcost = 0;
      for ($i = 1; $i < 9; $i++) {
        $name = "Ingredient".$i;
        if ($recipesql[$name] == 0)
          continue;
        $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipesql[$name])["realname"]);
        $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
        $rname = $recipesql[$name].":".$itemname;
        if (array_key_exists($rname, $ingredients)) {
          $ingredients[$rname] += 1;
        } else {
          $ingredients[$rname] = 1;
        }
      }
      foreach ($ingredients as $key => $quantity) {
        $itemid = explode(":", $key)[0];
        $cost = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$itemid." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
        $recipesqlcost += ($cost * $quantity);
      }
      $recipe[$a]["ingredients"] = $ingredients;
      $recipe[$a]["ingredientcost"] = $recipesqlcost;

      $recipe[$a]["price"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipesql["Result"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
      $recipe[$a]["pricestack"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipesql["Result"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 1")["price"];
      $recipe[$a]["stacksize"] = sqlQuery("SELECT stackSize FROM `item_basic` WHERE itemid = ".$recipesql["Result"])["stackSize"];
      if ($recipesql["Result"] != $recipesql["ResultHQ1"])
        $recipe[$a]["pricehq1"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipesql["ResultHQ1"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
      else
        $recipe[$a]["pricehq1"] = 0;
      if ($recipesql["ResultHQ1"] != $recipesql["ResultHQ2"])
        $recipe[$a]["pricehq2"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipesql["ResultHQ2"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
      else
        $recipe[$a]["pricehq2"] = 0;
      if ($recipesql["ResultHQ2"] != $recipesql["ResultHQ3"])
        $recipe[$a]["pricehq3"] = sqlQuery("SELECT price FROM `auction_house` WHERE itemid = ".$recipesql["ResultHQ3"]." AND seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND stack = 0")["price"];
      else
        $recipe[$a]["pricehq3"] = 0;

      $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipesql["Result"])["realname"]);
      $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
      $rname = $recipesql["Result"].":".$itemname;
      $recipe[$a]["result"] = $rname;
      $recipe[$a]["resultcount"] = $recipesql["ResultQty"];

      $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipesql["ResultHQ1"])["realname"]);
      $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
      $rname = $recipesql["ResultHQ1"].":".$itemname;
      $recipe[$a]["resulthq1"] = $rname;
      $recipe[$a]["resulthq1count"] = $recipesql["ResultHQ1Qty"];

      $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipesql["ResultHQ2"])["realname"]);
      $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
      $rname = $recipesql["ResultHQ2"].":".$itemname;
      $recipe[$a]["resulthq2"] = $rname;
      $recipe[$a]["resulthq2count"] = $recipesql["ResultHQ2Qty"];

      $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$recipesql["ResultHQ3"])["realname"]);
      $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
      $rname = $recipesql["ResultHQ3"].":".$itemname;
      $recipe[$a]["resulthq3"] = $rname;
      $recipe[$a]["resulthq3count"] = $recipesql["ResultHQ3Qty"];
      $a++;
    }
    $compiled["recipe"] = $recipe;

  }

  $json = json_encode($compiled);
  echo $json;

}

?>