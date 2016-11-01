<?php

require("include/html.inc");

$sortname = "";
$xmlfile = file_get_contents("ffxiah_items.xml");
$xmlfile=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xmlfile);
$xml = simplexml_load_string($xmlfile);
$ffxiah = $xml->children();
$z = 0;
foreach($ffxiah->item as $item) {
  //if ($items["int_id"] == intval($itemid)) {
  //  $sortname = $items["en_name"];
  //}
  //echo "ID: ".$item->int_id." ";
  //echo "Name: ".$item->en_name." ";
  //echo "Description: ".$item->en_description."\n";
  $count = sqlQuery("SELECT COUNT(*) FROM `item_info` WHERE itemid = ".$item->int_id)["COUNT(*)"];
  if ($count == 0) {
    if ($item->en_name != ".") {
      $sql = "INSERT INTO `item_info` (itemid, realname, sortname, description) VALUES (".$item->int_id.", '".$dcon->real_escape_string($item->log_name_singular)."', '".$dcon->real_escape_string($item->en_name)."', '".$dcon->real_escape_string($item->en_description)."')";
      $tmp = mysqli_query($dcon, $sql);
      $z++;
    }
  }
}
printf("%d records inserted into the database.\n", $z);

?>
