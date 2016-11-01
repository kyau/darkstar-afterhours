<?php

require("include/html.inc");

$file = "autotranslate.txt";

function mencode($string) {
  $field=strtoupper(bin2hex($string));
  $field=chunk_split($field,2,"\\x");
  $field= "\\x" . substr($field,0,-2);
  return $field;
}

function mdecode($str) {
  $str = str_replace("\\x", "", $str);
  return hex2bin($str);
}

function parseAutoTranslate($str) {
  $debug = false;
  //$regexp = "/[\s\S]*(\\\\xFD[\S]*\\\\xFD)[\s\S]*/";
//  $str = preg_replace($regexp, mencode("<span class='at-o'><i class='fa fa-chevron-left' aria-hidden='true'></i></span>N/A<span class='at-c'><i class='fa fa-chevron-right' aria-hidden='true'></i></span>"), $str);
/*
  $regexp2 = "/([\w-\"\'\.\/\?\!\:\[\]\(\)\△\○\□\× ]*)\s{2,}(\S*)/";
  preg_match_all($regexp, file_get_contents($file), $keys, PREG_PATTERN_ORDER);
  $keys = array_unique($keys);
  $str = str_replace("\\xFD\\x02\\x02\\x01\\x0B\\xFD", mencode("&lt;span class='at-o'&gt;&laquo;&lt;/span&gt;Hello!&lt;span class='at-c'&gt;&raquo;&lt;/span&gt;"), $str);
*/
  $loop = true;
  while ($loop) {
    //$regexp = "/[\s\S]*(\\\\xFD[\S]*\\\\xFD)[\s\S]*/";
    $regexps = "/\\\\xFD(.*?)\\\\xFD/";
    $og = $str;
    //echo var_dump($og)."<br/>--<br/>";
    if (preg_match($regexps, $og, $found)) {
      $og = preg_replace($regexps, '\\xFD\1\\xFD', $og, 1);
    } else {
      $loop = false;
    }
    if ($debug)
      echo var_dump($found)."<br/>";
    if (isset($found[0])) {
      if ($debug)
        echo "{{".$found[0]."}}<br/>";
      $regexp3 = '/([\S ]*)\s{2,}'.preg_quote($found[0]).'/';
      preg_match_all($regexp3, file_get_contents("autotranslate.txt"), $keys, PREG_PATTERN_ORDER);
      if (isset($keys[0][0])) {
        $found = $keys[0][0];
        $found = preg_replace($regexp3, '\1', $found, 1);
      } else {
        $found = "N/A";
      }
    } else {
      $found = "N/A";
    }
    //echo $regexp3."<br/>";
    if ($debug)
      echo "{".trim($found)."}<br/>---<br/>";
    //echo var_dump($keys)."<br/>---<br/>";
    $translated = "<span class='at-o'><i class='fa fa-chevron-left' aria-hidden='true'></i></span>".trim($found)."<span class='at-c'><i class='fa fa-chevron-right' aria-hidden='true'></i></span>";
    //echo $translated;
    //$regexp2 = "/([\s\S]*)\\\\xFD[\S]*\\\\xFD([\s\S]*)/";
    $regexp2 = "/(\\\\xFD)(.*?)(\\\\xFD)/";
    $str = preg_replace($regexp2, mencode($translated), $str, 1);
  }

  return $str;
}

$compiled = array();

// check to see if character exists
$sql = "SELECT speaker, message, datetime FROM `audit_chat` WHERE type = 'SAY' ORDER BY datetime DESC LIMIT 8;";
$tmp = mysqli_query($dcon, $sql);
$num = 0;
while($row = $tmp->fetch_assoc()) {
  $arr = array();
  $arr['name'] = $dcon->real_escape_string($row['speaker']);
  $chars = sqlQuery("SELECT charid FROM `chars` WHERE charname = '".$arr['name']."'");
  $arr['charid'] = $dcon->real_escape_string($chars['charid']);
  $stamp = strtotime($dcon->real_escape_string($row['datetime']));
  //$timestamp = date ( 'H:i:s', $stamp);
  //$timestamp = trim(date("m/d/Y h:ia",$stamp), "m");
  $timestamp = new DateTime(date("m/d/Y h:i:s",$stamp));
  $timestamp->add(new DateInterval("PT9H"));
  $new = trim($timestamp->format("m/d/Y H:ia"), "m");
  //$timestamp = strtotime(strtotime("3 hours"), $timestamp);
  $arr['timestamp'] = $new;
  $arr['message'] = mdecode(parseAutoTranslate(mencode($dcon->real_escape_string($row['message']))));
  $compiled[$num] = $arr;
  $num++;
}

$json = json_encode($compiled);
echo $json."\n";
//echo mencode("&lt;span class='at-o'&gt;&laquo;&lt;/span&gt;unknown&lt;span class='at-c'&gt;&raquo;&lt;/span&gt;");

?>