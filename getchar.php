<?php

require("include/html.inc");

$compiled = array();
$jobs = array("GENKAI","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH","GEO","RUN");

if (isset($_GET['id'])) {
  $charid = $_GET['id'];
  //$charid = '21828';
  // check to see if character exists
  $chars_data = sqlQuery("SELECT * FROM `chars` WHERE charid = ".$charid);
  $compiled['name'] = $chars_data["charname"];

  // pull character job information
  $char_jobs = array();
  $char_jobs_data = sqlQuery("SELECT genkai,war,mnk,whm,blm,rdm,thf,pld,drk,bst,brd,rng,sam,nin,drg,smn,blu,cor,pup,dnc,sch FROM `char_jobs` WHERE charid = ".$charid);
  for ($i = 0; $i < count($char_jobs_data); $i++) {
    $char_jobs[strtolower($jobs[$i])] = $char_jobs_data[strtolower($jobs[$i])];
  }
  $compiled['jobs'] = $char_jobs;
  // pull current job/subjob information
  $char_currentjob = sqlQuery("SELECT mjob, sjob, mlvl, slvl FROM `char_stats` WHERE charid = ".$charid);
  $compiled['mainjob'] = $jobs[$char_currentjob['mjob']].$char_currentjob['mlvl'];
  $compiled['subjob'] = $jobs[$char_currentjob['sjob']].$char_currentjob['slvl'];
  // pull character linkshell information
  $linkshell = sqlQuery("SELECT signature, itemId FROM `char_inventory` WHERE charid = ".$charid." AND location = 0 AND slot = (SELECT slotid FROM `char_equip` WHERE charid = ".$charid." AND equipslotid = 16)");
  if (isset($linkshell["signature"])) {
    if ($linkshell["itemId"] == "513")
      $compiled["ls_rank"] = 1;
    else if ($linkshell["itemId"] == "514")
      $compiled["ls_rank"] = 2;
    else if ($linkshell["itemId"] == "515")
      $compiled["ls_rank"] = 3;
    $compiled["ls_name"] = $linkshell["signature"];
  } else {
    $compiled["ls_name"] = "N/A";
    $compiled["ls_rank"] = 0;
  }
  /*
  $linkshell = sqlQuery("SELECT linkshellid1, linkshellrank1 FROM `accounts_sessions` WHERE charid = ".$charid);
  if ($linkshell["linkshellid1"] != 0) {
    $ls_name = sqlQuery("SELECT name FROM `linkshells` WHERE linkshellid = ".$linkshell["linkshellid1"])["name"];
    $ls_rank = $linkshell["linkshellrank1"];
    $compiled["ls_name"] = $ls_name;
    $compiled["ls_rank"] = $ls_rank;
  } else {
    $compiled["ls_name"] = "N/A";
    $compiled["ls_rank"] = 0;
  }
  */
  // pull zone information
  $zone = str_replace("_"," ", sqlQuery("SELECT name FROM `zone_settings` WHERE zoneid = (SELECT pos_zone FROM `chars` WHERE charid = ".$charid.")")['name']);
  $compiled['zone'] = $zone;
  // pull character crafting skills
  $sql = "SELECT * FROM `char_skills` WHERE charid = ".$charid." AND skillid BETWEEN 48 AND 57";
  $tmp = mysqli_query($dcon, $sql);
  while($row = $tmp->fetch_assoc()) {
    $crafting[$row['skillid']] = $row['value'];
  }
  $compiled['fishing'] = isset($crafting[48]) ? $crafting[48] / 10 : 0;
  $compiled['woodworking'] = isset($crafting[49]) ? $crafting[49] / 10 : 0;
  $compiled['smithing'] = isset($crafting[50]) ? $crafting[50] / 10 : 0;
  $compiled['goldsmithing'] = isset($crafting[51]) ? $crafting[51] / 10 : 0;
  $compiled['clothcraft'] = isset($crafting[52]) ? $crafting[52] / 10 : 0;
  $compiled['leathercraft'] = isset($crafting[53]) ? $crafting[53] / 10 : 0;
  $compiled['bonecraft'] = isset($crafting[54]) ? $crafting[54] / 10 : 0;
  $compiled['alchemy'] = isset($crafting[55]) ? $crafting[55] / 10 : 0;
  $compiled['cooking'] = isset($crafting[56]) ? $crafting[56] / 10 : 0;
  $compiled['synergy'] = isset($crafting[57]) ? $crafting[57] / 10 : 0;
  // get rank information
  $char_ranks_data = sqlQuery("SELECT rank_sandoria, rank_bastok, rank_windurst FROM `char_profile` WHERE charid = ".$charid);
  $compiled['rank_sandoria'] = isset($char_ranks_data['rank_sandoria']) ? $char_ranks_data['rank_sandoria'] : 1;
  $compiled['rank_bastok'] = isset($char_ranks_data['rank_bastok']) ? $char_ranks_data['rank_bastok'] : 1;
  $compiled['rank_windurst'] = isset($char_ranks_data['rank_windurst']) ? $char_ranks_data['rank_windurst'] : 1;
  // get player gil
  $char_gil = sqlQuery("SELECT quantity FROM `char_inventory` WHERE charid = ".$charid." AND itemId = 65535");
  $compiled['gil'] = isset($char_gil['quantity']) ? number_format($char_gil['quantity']) : 0;
  // pull character mission information
  //$missions = sqlQuery("SELECT missions FROM `chars` WHERE charid = ".$charid)["missions"];
  //$missionarray = unpack("i14/n/n", $missions);
  //echo var_dump($missionarray);
  // get current equipment
  $equipment = array();
  $slot = 0;
  for ($i = 0; $i < 16; $i++) {
    switch ($i) {
      case 0:
      case 1:
      case 2:
      case 3:
      case 4:
        $slot = $i;
        break;
      case 5:
        $slot = 9;
        break;
      case 6:
        $slot = 11;
        break;
      case 7:
        $slot = 12;
        break;
      case 8:
        $slot = 5;
        break;
      case 9:
        $slot = 6;
        break;
      case 10:
        $slot = 13;
        break;
      case 11:
        $slot = 14;
        break;
      case 12:
        $slot = 15;
        break;
      case 13:
        $slot = 10;
        break;
      case 14:
        $slot = 7;
        break;
      case 15:
        $slot = 8;
        break;
      default:
        $slot = $i;
    }
    $tmpequip = sqlQuery("SELECT * FROM `char_inventory` WHERE charid = ".$charid." AND location = (SELECT containerid FROM `char_equip` WHERE charid = ".$charid." AND equipslotid = ".$i.") AND slot = (SELECT slotid FROM `char_equip` WHERE charid = ".$charid." AND equipslotid = ".$i.")");
    $equipment[$slot] = isset($tmpequip['itemId']) ? $tmpequip['itemId'] : "0";
    //$equipment[$i] = isset($tmpequip['itemId']) ? $tmpequip['itemId'] : "0";
  }
  $sortedequip = array();
  for ($i = 0; $i < 16; $i++) {
    switch ($i) {
      case 0:
        $sortedequip[0] = $equipment[$i];
        break;
      case 1:
        $sortedequip[1] = $equipment[$i];
        break;
      case 2:
        $sortedequip[2] = $equipment[$i];
        break;
      case 3:
        $sortedequip[3] = $equipment[$i];
        break;
      case 4:
        $sortedequip[4] = $equipment[$i];
        break;
      case 5:
        $sortedequip[5] = $equipment[9];
        break;
      case 6:
        $sortedequip[6] = $equipment[11];
        break;
      case 7:
        $sortedequip[7] = $equipment[12];
        break;
      case 8:
        $sortedequip[8] = $equipment[5];
        break;
      case 9:
        $sortedequip[9] = $equipment[6];
        break;
      case 10:
        $sortedequip[10] = $equipment[13];
        break;
      case 11:
        $sortedequip[11] = $equipment[14];
        break;
      case 12:
        $sortedequip[12] = $equipment[15];
        break;
      case 13:
        $sortedequip[13] = $equipment[10];
        break;
      case 14:
        $sortedequip[14] = $equipment[7];
        break;
      case 15:
        $sortedequip[15] = $equipment[8];
        break;
    }
  }
  $compiled['equip'] = $sortedequip;
  // get current race/sex/face
  $char_look = sqlQuery("SELECT face, race FROM `char_look` WHERE charid = ".$charid);
  $char_img = "";
  $char_race = "";
  switch ($char_look['race']) {
    default:
    case 1:
      $char_img = "images/mini_face/hh";
      $char_race = "H&#9792;";
      break;
    case 2:
      $char_img = "images/mini_face/h";
      $char_race = "H&#9794;";
      break;
    case 3:
      $char_img = "images/mini_face/ee";
      $char_race = "E&#9792;";
      break;
    case 4:
      $char_img = "images/mini_face/e";
      $char_race = "E&#9794;";
      break;
    case 5:
      $char_img = "images/mini_face/t";
      $char_race = "T&#9792;";
      break;
    case 6:
      $char_img = "images/mini_face/tt";
      $char_race = "T&#9794;";
      break;
    case 7:
      $char_img = "images/mini_face/m";
      $char_race = "M&#9794;";
      break;
    case 8:
      $char_img = "images/mini_face/g";
      $char_race = "G&#9792;";
      break;
  }
  switch ($char_look['face']) {
    default:
    case 0:
      $char_img = $char_img."1_a.gif";
      break;
    case 1:
      $char_img = $char_img."1_b.gif";
      break;
    case 2:
      $char_img = $char_img."2_a.gif";
      break;
    case 3:
      $char_img = $char_img."2_b.gif";
      break;
    case 4:
      $char_img = $char_img."3_a.gif";
      break;
    case 5:
      $char_img = $char_img."3_b.gif";
      break;
    case 6:
      $char_img = $char_img."4_a.gif";
      break;
    case 7:
      $char_img = $char_img."4_b.gif";
      break;
    case 8:
      $char_img = $char_img."5_a.gif";
      break;
    case 9:
      $char_img = $char_img."5_b.gif";
      break;
    case 10:
      $char_img = $char_img."6_a.gif";
      break;
    case 11:
      $char_img = $char_img."6_b.gif";
      break;
    case 12:
      $char_img = $char_img."7_a.gif";
      break;
    case 13:
      $char_img = $char_img."7_b.gif";
      break;
    case 14:
      $char_img = $char_img."8_a.gif";
      break;
    case 15:
      $char_img = $char_img."8_b.gif";
      break;
  }
  $compiled['char_img'] = $char_img;
  $compiled['char_race'] = $char_race;
  // get maat jobs
  $char_maat = sqlQuery("SELECT war,mnk,whm,blm,rdm,thf,pld,drk,bst,brd,rng,sam,nin,drg,smn FROM `char_jobs` WHERE charid = ".$charid);
  $maatjobs = 0;
  for ($i = 0; $i < count($char_maat); $i++) {
    if ($char_maat[strtolower($jobs[$i+1])] >= 75) {
      $maatjobs += 1;
    }
  }
  $compiled['maat'] = $maatjobs;
  // auction house information
  $sql = "SELECT * FROM `auction_house` WHERE buyer_name = '".$compiled['name']."' OR seller_name = '".$compiled['name']."' ORDER BY `auction_house`.`sell_date` DESC LIMIT 10";
  $tmp = mysqli_query($dcon, $sql);
  $ah = array();
  $z = 0;
  while($row = $tmp->fetch_assoc()) {
    $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$row['itemid'])['realname']);
    $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
    $ah[$z]['itemid'] = $row['itemid'];
    $ah[$z]['itemname'] = $itemname;
    if ($row['stack'])
      $ah[$z]['itemname'] .= " x12";
    //$ah[$z]['buyer'] = $row['buyer_name'];
    //$ah[$z]['seller'] = $row['seller_name'];
    if ($row['buyer_name'] == "DarkStar")
      $ah[$z]['buyer'] = "AfterHours";
    else
      $ah[$z]['buyer'] = $row['buyer_name'];
    if ($row['seller_name'] == "DarkStar")
      $ah[$z]['seller'] = "AfterHours";
    else
      $ah[$z]['seller'] = $row['seller_name'];
    $ah[$z]['price'] = number_format($row['sale']);
    //$ah[$z]['date'] = trim(date("m/d/Y h:ia",$row['sell_date']), "m");
    $timestamp = new DateTime(date("m/d/Y h:i:s",$row['sell_date']));
    //$timestamp->add(new DateInterval("PT9H"));
    $ah[$z]['date'] = trim($timestamp->format("m/d/Y h:ia"), "m");
    $z++;
  }
  $compiled['ah'] = $ah;
}

$json = json_encode($compiled);
echo $json;

?>