<?php

require("include/html.inc");

$compiled = array();
$jobs = array("GENKAI","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH","GEO","RUN");
$FLAG_GM = 0x04000000;
$FLAG_GM_SENIOR = 0x05000000;
$FLAG_GM_LEAD = 0x06000000;
$FLAG_GM_PRODUCER = 0x07000000;

$chars = array();
$i = 0;

// pull list of all jobs
$sql = "SELECT * FROM `accounts_sessions`";
$tmp = mysqli_query($dcon, $sql);
while($row = $tmp->fetch_assoc()) {
  $tmparr = array();
  $sql = sqlQuery("SELECT * FROM `chars` WHERE charid = ".$row["charid"]);
  $tmparr['charid'] = $sql['charid'];
  $tmparr['name'] = $sql['charname'];
  $tmparr['nation'] = $sql['nation'];
  $nameflags = intval(sqlQuery("SELECT nameflags FROM `char_stats` WHERE charid = ".$row["charid"])["nameflags"]);
  // player flags
  if ($nameflags & $FLAG_GM || $nameflags & $FLAG_GM_SENIOR || $nameflags & $FLAG_GM_LEAD || $nameflags & $FLAG_GM_PRODUCER) {
    $tmparr["gm"] = 1;
  } else {
    $tmparr["gm"] = 0;
  }
  // zone
  $tmparr['zone'] = sqlQuery("SELECT name FROM `zone_settings` WHERE zoneid = ".$sql['pos_zone'])['name'];
  // current job/subjob
  $char_currentjob = sqlQuery("SELECT mjob, sjob, mlvl, slvl FROM `char_stats` WHERE charid = ".$row['charid']);
  $tmparr['online'] = sqlQuery("SELECT COUNT(*) FROM `accounts_sessions` WHERE charid = ".$row['charid'])['COUNT(*)'];
  $tmparr['mainjob'] = $jobs[$char_currentjob['mjob']].$char_currentjob['mlvl'];
  $tmparr['subjob'] = $jobs[$char_currentjob['sjob']].$char_currentjob['slvl'];
  $compiled["users"][$i] = $tmparr;
  $i++;
}

$json = json_encode($compiled);
echo $json;

?>