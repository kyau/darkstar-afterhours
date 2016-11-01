<?php

require("include/html.inc");

$compiled = array();
$jobs = array("GENKAI","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH","GEO","RUN");

// pull list of all jobs
$sql = "SELECT * FROM `chars` ORDER BY `chars`.`charname` ASC";
$tmp = mysqli_query($dcon, $sql);
$i = 0;
while($row = $tmp->fetch_assoc()) {
  $tmparr = array();
  $tmparr['charid'] = $row['charid'];
  $tmparr['name'] = $row['charname'];
  $tmparr['nation'] = $row['nation'];
  // zone
  $tmparr['zone'] = sqlQuery("SELECT name FROM `zone_settings` WHERE zoneid = ".$row['pos_zone'])['name'];
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