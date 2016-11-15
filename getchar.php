<?php

require("include/html.inc");

function linkshellColor($color) {
	$color = dechex($color);
	$color = substr($color, 1);
	$r=0;
	$g=0;
	$b=0;
	if(strlen($color) == 3) {
		$r = hexdec(substr($color,2,1).substr($color,2,1));
		$g = hexdec(substr($color,1,1).substr($color,1,1));
		$b = hexdec(substr($color,0,1).substr($color,0,1));
	}
	$rgb = array($r, $g, $b);
	return $rgb;
}

function createIcon($type, $rgb) {
	$output = "";
	$output .= shell_exec('convert images/icons/base.png -fill "rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')" -colorize 100 images/icons/tmp.png');
	$output .= shell_exec('convert images/icons/'.$type.'.png images/icons/tmp.png \( -clone 0 -alpha extract \) \( -clone 1 -clone 2 -alpha off -compose copy_opacity -composite -alpha on -channel a -evaluate multiply 0.8 +channel \) -delete 1,2 -compose overlay -composite images/icons/'.$type.'/'.$rgb[0].$rgb[1].$rgb[2].'.png');
	$output .= shell_exec("rm images/icons/tmp.png");
	return $output;
}

$compiled = array();
$jobs = array("GENKAI","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH","GEO","RUN");
$mission_array = array(
	1 => "Current Sandy Mission",
	3 => "SMASH THE ORCISH SCOUTS",
	4 => "BAT HUNT",
	5 => "SAVE THE CHILDREN",
	6 => "THE RESCUE DRILL",
	7 => "THE DAVOI REPORT",
	8 => "JOURNEY ABROAD",
	9 => "JOURNEY TO BASTOK",
	10 => "JOURNEY TO WINDURST",
	11 => "JOURNEY TO BASTOK2",
	12 => "JOURNEY TO WINDURST2",
	13 => "INFILTRATE DAVOI",
	14 => "THE CRYSTAL SPRING",
	15 => "APPOINTMENT TO JEUNO",
	16 => "MAGICITE SAN D ORIA",
	17 => "THE RUINS OF FEI YIN",
	18 => "THE SHADOW LORD",
	19 => "LEAUTE S LAST WISHES",
	20 => "RANPERRE S FINAL REST",
	21 => "PRESTIGE OF THE PAPSQUE",
	22 => "THE SECRET WEAPON",
	23 => "COMING OF AGE",
	24 => "LIGHTBRINGER",
	25 => "BREAKING BARRIERS",
	26 => "THE HEIR TO THE LIGHT",
	67 => "Current Bastok Mission",
	69 => "THE ZERUHN REPORT",
	70 => "GEOLOGICAL SURVEY",
	71 => "FETICHISM",
	72 => "THE CRYSTAL LINE",
	73 => "WADING BEASTS",
	74 => "THE EMISSARY",
	75 => "THE EMISSARY SANDORIA",
	76 => "THE EMISSARY WINDURST",
	77 => "THE EMISSARY SANDORIA2",
	78 => "THE EMISSARY WINDURST2",
	79 => "THE FOUR MUSKETEERS",
	80 => "TO THE FORSAKEN MINES",
	81 => "JEUNO MISSION",
	82 => "MAGICITE BASTOK",
	83 => "DARKNESS RISING",
	84 => "XARCABARD LAND OF TRUTHS",
	85 => "RETURN OF THE TALEKEEPER",
	86 => "THE PIRATE S COVE",
	87 => "THE FINAL IMAGE",
	88 => "ON MY WAY",
	89 => "THE CHAINS THAT BIND US",
	90 => "ENTER THE TALEKEEPER",
	91 => "THE SALT OF THE EARTH",
	92 => "WHERE TWO PATHS CONVERGE",
	133 => "Current Windy Mission",
	135 => "THE HORUTOTO RUINS EXPERIMENT",
	136 => "THE HEART OF THE MATTER",
	137 => "THE PRICE OF PEACE",
	138 => "LOST FOR WORDS",
	139 => "A TESTING TIME",
	140 => "THE THREE KINGDOMS",
	141 => "THE THREE KINGDOMS SANDORIA",
	142 => "THE THREE KINGDOMS BASTOK",
	143 => "THE THREE KINGDOMS SANDORIA2",
	144 => "THE THREE KINGDOMS BASTOK2",
	145 => "TO EACH HIS OWN RIGHT",
	146 => "WRITTEN IN THE STARS",
	147 => "A NEW JOURNEY",
	148 => "MAGICITE",
	149 => "THE FINAL SEAL",
	150 => "THE SHADOW AWAITS",
	151 => "FULL MOON FOUNTAIN",
	152 => "SAINTLY INVITATION",
	153 => "THE SIXTH MINISTRY",
	154 => "AWAKENING OF THE GODS",
	155 => "VAIN",
	156 => "THE JESTER WHO D BE KING",
	157 => "DOLL OF THE DEAD",
	158 => "MOON READING",
	199 => "Current Zilart Mission",
	201 => "THE NEW FRONTIER",
	205 => "WELCOME TNORG",
	207 => "KAZAMS CHIEFTAINESS",
	209 => "THE TEMPLE OF UGGALEPIH",
	211 => "HEADSTONE PILGRIMAGE",
	213 => "THROUGH THE QUICKSAND CAVES",
	215 => "THE CHAMBER OF ORACLES",
	217 => "RETURN TO DELKFUTTS TOWER",
	219 => "ROMAEVE",
	221 => "THE TEMPLE OF DESOLATION",
	223 => "THE HALL OF THE GODS",
	224 => "THE MITHRA AND THE CRYSTAL",
	225 => "THE GATE OF THE GODS",
	227 => "ARK ANGELS",
	228 => "THE SEALED SHRINE",
	229 => "THE CELESTIAL NEXUS",
	231 => "AWAKENING",
	232 => "THE LAST VERSE",
	258 => "**UNKNOWN**",
	265 => "Current TOAU Mission",
	267 => "LAND OF SACRED SERPENTS",
	268 => "IMMORTAL SENTRIES",
	269 => "PRESIDENT SALAHEEM",
	270 => "KNIGHT OF GOLD",
	271 => "CONFESSIONS OF ROYALTY",
	272 => "EASTERLY WINDS",
	273 => "WESTERLY WINDS",
	274 => "A MERCENARY LIFE",
	275 => "UNDERSEA SCOUTING",
	276 => "ASTRAL WAVES",
	277 => "IMPERIAL SCHEMES",
	278 => "ROYAL PUPPETEER",
	279 => "LOST KINGDOM",
	280 => "THE DOLPHIN CREST",
	281 => "THE BLACK COFFIN",
	282 => "GHOSTS OF THE PAST",
	283 => "GUESTS OF THE EMPIRE",
	284 => "PASSING GLORY",
	285 => "SWEETS FOR THE SOUL",
	286 => "TEAHOUSE TUMULT",
	287 => "FINDERS KEEPERS",
	288 => "SHIELD OF DIPLOMACY",
	289 => "SOCIAL GRACES",
	290 => "FOILED AMBITION",
	291 => "PLAYING THE PART",
	292 => "SEAL OF THE SERPENT",
	293 => "MISPLACED NOBILITY",
	294 => "BASTION OF KNOWLEDGE",
	295 => "PUPPET IN PERIL",
	296 => "PREVALENCE OF PIRATES",
	297 => "SHADES OF VENGEANCE",
	298 => "IN THE BLOOD",
	299 => "SENTINELS HONOR",
	300 => "TESTING THE WATERS",
	301 => "LEGACY OF THE LOST",
	302 => "GAZE OF THE SABOTEUR",
	303 => "PATH OF BLOOD",
	304 => "STIRRINGS OF WAR",
	305 => "ALLIED RUMBLINGS",
	306 => "UNRAVELING REASON",
	307 => "LIGHT OF JUDGMENT",
	308 => "PATH OF DARKNESS",
	309 => "FANGS OF THE LION",
	310 => "NASHMEIRAS PLEA",
	311 => "URHGAN MISSION 44",
	312 => "IMPERIAL CORONATION",
	313 => "THE EMPRESS CROWNED",
	314 => "ETERNAL MERCENARY",
	324 => "**UNKNOWN**",
	331 => "Current WoTG Mission",
	333 => "CAVERNOUS MAWS",
	334 => "BACK TO THE BEGINNING",
	335 => "CAIT SITH",
	336 => "THE QUEEN OF THE DANCE",
	337 => "WHILE THE CAT IS AWAY",
	338 => "A TIMESWEPT BUTTERFLY",
	339 => "PURPLE THE NEW BLACK",
	340 => "IN THE NAME OF THE FATHER",
	341 => "DANCERS IN DISTRESS",
	342 => "DAUGHTER OF A KNIGHT",
	343 => "A SPOONFUL OF SUGAR",
	344 => "AFFAIRS OF STATE",
	345 => "BORNE BY THE WIND",
	346 => "A NATION ON THE BRINK",
	347 => "CROSSROADS OF TIME",
	348 => "SANDSWEPT MEMORIES",
	349 => "NORTHLAND EXPOSURE",
	350 => "TRAITOR IN THE MIDST",
	351 => "BETRAYAL AT BEAUCEDINE",
	352 => "ON THIN ICE",
	353 => "PROOF OF VALOR",
	354 => "A SANGUINARY PRELUDE",
	355 => "DUNGEONS AND DANCERS",
	356 => "DISTORTER OF TIME",
	357 => "THE WILL OF THE WORLD",
	358 => "FATE IN HAZE",
	359 => "THE SCENT OF BATTLE",
	360 => "ANOTHER WORLD",
	361 => "A HAWK IN REPOSE",
	362 => "THE BATTLE OF XARCABARD",
	363 => "PRELUDE TO A STORM",
	364 => "STORM S CRESCENDO",
	365 => "INTO THE BEAST S MAW",
	366 => "THE HUNTER ENSNARED",
	367 => "FALL OF THE HAWK",
	368 => "DARKNESS DESCENDS",
	369 => "ADIEU LILISETTE",
	370 => "BY THE FADING LIGHT",
	371 => "EDGE OF EXISTENCE",
	372 => "HER MEMORIES",
	373 => "FORGET ME NOT",
	374 => "PILLAR OF HOPE",
	375 => "GLIMMER OF LIFE",
	376 => "TIME SLIPS AWAY",
	377 => "WHEN WILLS COLLIDE",
	378 => "WHISPERS OF DAWN",
	379 => "A DREAMY INTERLUDE",
	380 => "CAIT IN THE WOODS",
	381 => "FORK IN THE ROAD",
	382 => "MAIDEN OF THE DUSK",
	383 => "WHERE IT ALL BEGAN",
	384 => "A TOKEN OF TROTH",
	385 => "LEST WE FORGET",
	390 => "**UNKNOWN**",
	397 => "Current COP Mission",
	399 => "ANCIENT FLAMES BECKON",
	400 => "THE RITES OF LIFE",
	401 => "BELOW THE ARKS",
	402 => "THE MOTHERCRYSTALS",
	404 => "AN INVITATION WEST",
	414 => "THE LOST CITY",
	415 => "DISTANT BELIEFS",
	416 => "AN ETERNAL MELODY",
	417 => "ANCIENT VOWS",
	419 => "THE CALL OF THE WYRMKING",
	426 => "A VESSEL WITHOUT A CAPTAIN",
	427 => "THE ROAD FORKS",
	428 => "DESCENDANTS OF A LINE LOST",
	429 => "COMEDY OF ERRORS ACT I",
	430 => "TENDING AGED WOUNDS",
	431 => "DARKNESS NAMED",
	432 => "SHELTERING DOUBT",
	439 => "THE SAVAGE",
	440 => "THE SECRETS OF WORSHIP",
	441 => "SLANDEROUS UTTERINGS",
	442 => "THE ENDURING TUMULT OF WAR",
	451 => "DESIRES OF EMPTINESS",
	453 => "THREE PATHS",
	456 => "**UNKNOWN**",
	459 => "FOR WHOM THE VERSE IS SUNG",
	464 => "A PLACE TO RETURN",
	465 => "MORE QUESTIONS THAN ANSWERS",
	466 => "ONE TO BE FEARED",
	467 => "CHAINS AND BONDS",
	476 => "FLAMES IN THE DARKNESS",
	477 => "FIRE IN THE EYES OF MEN",
	479 => "CALM BEFORE THE STORM",
	480 => "THE WARRIOR S PATH",
	486 => "GARDEN OF ANTIQUITY",
	489 => "A FATE DECIDED",
	490 => "WHEN ANGELS FALL",
	491 => "DAWN",
	493 => "THE LAST VERSE",
	529 => "Current Campaign Mission",
	595 => "Current ACP Mission",
	597 => "A CRYSTALLINE PROPHECY",
	598 => "THE ECHO AWAKENS",
	599 => "GATHERER OF LIGHT I",
	600 => "GATHERER OF LIGHT II",
	601 => "THOSE WHO LURK IN SHADOWS I",
	602 => "THOSE WHO LURK IN SHADOWS II",
	603 => "THOSE WHO LURK IN SHADOWS III",
	604 => "REMEMBER ME IN YOUR DREAMS",
	605 => "BORN OF HER NIGHTMARES",
	606 => "BANISHING THE ECHO",
	607 => "ODE OF LIFE BESTOWING",
	608 => "A CRYSTALLINE PROPHECY FIN",
	661 => "Current MKD Mission",
	663 => "A MOOGLE KUPO DETAT",
	664 => "DRENCHED IT BEGAN WITH A RAINDROP",
	665 => "HASTEN IN A JAM IN JEUNO",
	666 => "WELCOME TO MY DECREPIT DOMICILE",
	667 => "CURSES A HORRIFICALLY HARROWING HEX",
	668 => "AN ERRAND THE PROFESSORS PRICE",
	669 => "SHOCK ARRANT ABUSE OF AUTHORITY",
	670 => "LENDER BEWARE READ THE FINE PRINT",
	671 => "RESCUE A MOOGLES LABOR OF LOVE",
	672 => "ROAR A CAT BURGLAR BARES HER FANGS",
	673 => "RELIEF A TRIUMPHANT RETURN",
	674 => "JOY SUMMONED TO A FABULOUS FETE",
	675 => "A CHALLENGE YOU COULD BE A WINNER",
	676 => "SMASH A MALEVOLENT MENACE",
	677 => "A MOOGLE KUPO DETAT FIN",
	727 => "Current ASA Mission",
	729 => "A SHANTOTTO ASCENSION",
	730 => "BURGEONING DREAD",
	731 => "THAT WHICH CURDLES BLOOD",
	732 => "SUGAR COATED DIRECTIVE",
	733 => "ENEMY OF THE EMPIRE I",
	734 => "ENEMY OF THE EMPIRE II",
	735 => "SUGAR COATED SUBTERFUGE",
	736 => "SHANTOTTO IN CHAINS",
	737 => "FOUNTAIN OF TROUBLE",
	738 => "BATTARU ROYALE",
	739 => "ROMANCING THE CLONE",
	740 => "SISTERS IN ARMS",
	741 => "PROJECT SHANTOTTOFICATION",
	742 => "AN UNEASY PEACE",
	743 => "A SHANTOTTO ASCENSION FIN",
	793 => "Current SOA Mission",
	795 => "RUMORS FROM THE WEST",
	796 => "THE GEOMAGNETRON",
	797 => "ONWARD TO ADOULIN",
	798 => "HEARTWIGNS AND THE KINDHEARTED",
	799 => "PIONEER REGISTRATION",
	800 => "LIFE ON THE FRONTIER",
	801 => "MEETING OF THE MINDS",
	802 => "ARCIELA APPEARS AGAIN",
	803 => "BUILDING PROSPECTS",
	804 => "THE LIGHT SHINING IN YOUR EYES",
	805 => "THE HEIRLOOM",
	806 => "AN AIMLESS JOURNEY",
	807 => "ORTHARSYNE",
	808 => "IN THE PRESENCE OF ROYALTY",
	809 => "THE TWIN WORLD TREES",
	810 => "HONOR AND AUDACITY",
	811 => "THE WATERGARDEN COLISEUM",
	812 => "FRICTION AND FISSURES",
	813 => "THE CELENNIA MEMORIAL LIBRARY",
	814 => "FOR WHOM DO WE TOIL",
	815 => "AIMING FOR YGNAS",
	816 => "CALAMITY IN THE KITCHEN",
	817 => "ARCIELA S PROMISE",
	818 => "PREDATOR AND PREY",
	819 => "BEHIND THE SLUICES",
	820 => "THE LEAFKIN MONARCH",
	821 => "YGGDRASIL",
	822 => "RETURN OF THE EXORCIST",
	823 => "THE MERCILESS ONE",
	824 => "A CURSE FROM THE PAST",
	825 => "THE PURGATION",
	826 => "THE KEY",
	827 => "THE PRINCESSS DILEMMA",
	828 => "DARK CLOUDS AHEAD",
	829 => "THE SMALLEST OF FAVORS",
	830 => "SUMMONED BY SPIRITS",
	831 => "EVIL ENTITIES",
	832 => "ADOULIN CALLING",
	833 => "THE DISAPPEARANCE OF NYLINE",
	834 => "SHARED CONSCIOUSNESS",
	835 => "CLEAR SKIES",
	836 => "THE MAN IN BLACK",
	837 => "TO THE VICTOR",
	838 => "AN EXTRAORDINARY GENTLEMAN",
	839 => "THE ORDERS TREASURES",
	840 => "AUGUSTS HEIRLOOM",
	841 => "BEAUTY AND THE BEAST",
	842 => "WILDCAT WITH A GOLD PELT",
	843 => "IN SEARCH OF ARCIELA",
	844 => "LOOKING FOR LEADS",
	845 => "DRIFTING NORTHWEST",
	846 => "KUMHAU THE FLASHFROST NAAKUAL",
	847 => "SOUL SIPHON",
	848 => "STONEWALLED",
	849 => "SALVATION",
	850 => "GLIMMER OF PORTENT",
	851 => "FIN"
);

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
    if ($linkshell["itemId"] == "513") {
      $compiled["ls_rank"] = 1;
  	  $ls = "linkshell";
    } else if ($linkshell["itemId"] == "514") {
      $compiled["ls_rank"] = 2;
  	  $ls = "pearlsack";
    } else if ($linkshell["itemId"] == "515") {
      $compiled["ls_rank"] = 3;
  	  $ls = "linkpearl";
    }
    $compiled["ls_name"] = $linkshell["signature"];
    $color = sqlQuery("SELECT color FROM `linkshells` WHERE name = '".$linkshell["signature"]."'")["color"];
    $rgb = linkshellColor($color);
    if (!file_exists("images/icons/".$ls."/".$rgb[0].$rgb[1].$rgb[2].".png")) {
    	$compiled["createIconOutput"] = createIcon($ls, $rgb);
    }
    $compiled["ls_color"] = $rgb;
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
    $craftrank[$row['skillid']] = (($row['rank'] + 1) * 10);
  }
  $compiled['fishing'] = isset($crafting[48]) ? $crafting[48] / 10 : 0;
  $compiled['fishingrank'] = isset($craftrank[48]) ? $crafrank[48] : 0;
  $compiled['woodworking'] = isset($crafting[49]) ? $crafting[49] / 10 : 0;
  $compiled['woodworkingrank'] = isset($craftrank[49]) ? $craftrank[49] : 0;
  $compiled['smithing'] = isset($crafting[50]) ? $crafting[50] / 10 : 0;
  $compiled['smithingrank'] = isset($craftrank[50]) ? $craftrank[50] : 0;
  $compiled['goldsmithing'] = isset($crafting[51]) ? $crafting[51] / 10 : 0;
  $compiled['goldsmithingrank'] = isset($craftrank[51]) ? $craftrank[51] : 0;
  $compiled['clothcraft'] = isset($crafting[52]) ? $crafting[52] / 10 : 0;
  $compiled['clothcraftrank'] = isset($craftrank[52]) ? $craftrank[52] : 0;
  $compiled['leathercraft'] = isset($crafting[53]) ? $crafting[53] / 10 : 0;
  $compiled['leathercraftrank'] = isset($craftrank[53]) ? $craftrank[53] : 0;
  $compiled['bonecraft'] = isset($crafting[54]) ? $crafting[54] / 10 : 0;
  $compiled['bonecraftrank'] = isset($craftrank[54]) ? $craftrank[54] : 0;
  $compiled['alchemy'] = isset($crafting[55]) ? $crafting[55] / 10 : 0;
  $compiled['alchemyrank'] = isset($craftrank[55]) ? $craftrank[55] : 0;
  $compiled['cooking'] = isset($crafting[56]) ? $crafting[56] / 10 : 0;
  $compiled['cookingrank'] = isset($craftrank[56]) ? $craftrank[56] : 0;
  $compiled['synergy'] = isset($crafting[57]) ? $crafting[57] / 10 : 0;
  $compiled['synergyrank'] = isset($craftrank[57]) ? $craftrank[57] : 0;

  // get rank information
  $char_ranks_data = sqlQuery("SELECT rank_sandoria, rank_bastok, rank_windurst FROM `char_profile` WHERE charid = ".$charid);
  $compiled['rank_sandoria'] = isset($char_ranks_data['rank_sandoria']) ? $char_ranks_data['rank_sandoria'] : 1;
  $compiled['rank_bastok'] = isset($char_ranks_data['rank_bastok']) ? $char_ranks_data['rank_bastok'] : 1;
  $compiled['rank_windurst'] = isset($char_ranks_data['rank_windurst']) ? $char_ranks_data['rank_windurst'] : 1;
  // get player gil
  $char_gil = sqlQuery("SELECT quantity FROM `char_inventory` WHERE charid = ".$charid." AND itemId = 65535");
  $compiled['gil'] = isset($char_gil['quantity']) ? number_format($char_gil['quantity']) : 0;
  // pull character mission information
  $missions = sqlQuery("SELECT missions FROM `chars` WHERE charid = ".$charid)["missions"];
  //$output = "";
  $compiled["missions"]["sandoria"] = "None";
  $compiled["missions"]["bastok"] = "None";
  $compiled["missions"]["windurst"] = "None";
  $compiled["missions"]["zilart"] = "None";
  $compiled["missions"]["toau"] = "None";
  $compiled["missions"]["wotg"] = "None";
  $compiled["missions"]["cop"] = "None";
  $compiled["missions"]["campaign"] = "None";
  $compiled["missions"]["acp"] = "None";
  $compiled["missions"]["mxd"] = "None";
  $compiled["missions"]["asa"] = "None";
  $compiled["missions"]["soa"] = "None";
  $kid = unpack('C*', $missions);
  $kida = array_merge($kid, $mission_array);
   
  $statusacp = array();
  $statusmxd = array();
  $statusasa = array();
  foreach($kid as $key=>$value){
    $status="$value";
	if($value==1 && $key !=1 && $key !=67 && $key !=133 && $key !=199 && $key !=265 && $key !=331 && $key !=397 && $key !=595 && $key !=661 && $key !=727 && $key !=793){
    	$status="COMPLETE";
    }
    if($value>0 && $key ==1 || $value>0 && $key ==67 || $value>0 && $key ==133 || $value>0 && $key ==199 || $value>0 && $key ==265 || $value>0 && $key ==331 || $value>0 && $key ==397 || $value>0 && $key ==595 || $value>0 && $key ==661 || $value>0 && $key ==727 || $value>0 && $key ==793){
    	$newvalue=$key+2+$value;
    	$status=$mission_array[$newvalue];
    	$status=str_replace('_',' ',$status);
    	if ($status != "**UNKNOWN**" && ($key > 500 && $key < 610)) {
			array_push($statusacp, $status);
    	}
    	if ($status != "**UNKNOWN**" && ($key > 655 && $key < 680)) {
    		array_push($statusmxd, $status);
    	}
    	if ($status != "**UNKNOWN**" && ($key > 725 && $key < 750)) {
    		array_push($statusasa, $status);
    	}
    }
    if($value==255){
    	$status="NONE";
    }
    if($value==0 && $key !=1 && $key !=67 && $key !=133 && $key !=199 && $key !=265 && $key !=331 && $key !=397 && $key !=595 && $key !=661 && $key !=727 && $key !=793){
    	$status="UNAVAILABLE";
    }
    if($value==0 && $key ==1 || $value==0 && $key ==67 || $value==0 && $key ==133 || $value==0 && $key ==199 || $value==0 && $key ==265 || $value==0 && $key ==331 || $value==0 && $key ==397 || $value==0 && $key ==595 || $value==0 && $key ==661 || $value==0 && $key ==727 || $value==0 && $key ==793){
    	$status="NONE";
    }
	if(!isset($mission_array[$key]) or $key>=495 or $key==9 or $key==10 or $key==11 or $key==12 or $key==75 or $key==76 or $key==77 or $key==78 or $key==141 or $key==142 or $key==143 or $key==144){
		if ($key==595 && !empty($statusacp))
			$compiled["missions"]["acp"] = ucwords(strtolower(implode(" / ", $statusacp)));
		if ($key==661 && !empty($statusmxd))
			$compiled["missions"]["mxd"] = ucwords(strtolower(implode(" / ", $statusmxd)));
		if ($key==727 && !empty($statusasa))
			$compiled["missions"]["asa"] = ucwords(strtolower(implode(" / ", $statusasa)));
	}else{
		if($key==1){
			$compiled["missions"]["sandoria"] = ucwords(strtolower($status));
		}
		if($key==67){
			$compiled["missions"]["bastok"] = ucwords(strtolower($status));
		}
		if($key==133){
			$compiled["missions"]["windurst"] = ucwords(strtolower($status));
		}
		if($key==199){
			$compiled["missions"]["zilart"] = ucwords(strtolower($status));
		}
		if($key==265){
			$compiled["missions"]["toau"] = ucwords(strtolower($status));
		}
		if($key==331){
			$compiled["missions"]["wotg"] = ucwords(strtolower($status));
		}
		if($key==397){
			$compiled["missions"]["cop"] = ucwords(strtolower($status));
		}
		if($key==529){
			$compiled["missions"]["campaign"] = ucwords(strtolower($status));
		}
		if($key==595){
			$compiled["missions"]["acp"] = ucwords(strtolower($status));
			//$compiled["missions"]["acp"] = $tmp;
		}
		if($key==661){
			$compiled["missions"]["mxd"] = ucwords(strtolower($status));
		}
		if($key==727){
			$compiled["missions"]["asa"] = ucwords(strtolower($status));
		}
		if($key==793){
			$compiled["missions"]["soa"] = ucwords(strtolower($status));
		}
    }
  }
  //$compiled["missions"] = $output;
  //$missionarray = unpack("i14/n/n", $missions);
  //echo var_dump($missionarray);
  // get current equipment
  $equipment = array();
  $equipsig = array();
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
    $equipsig[$slot] = isset($tmpequip['signature']) ? $tmpequip['signature'] : "";
    //$equipment[$i] = isset($tmpequip['itemId']) ? $tmpequip['itemId'] : "0";
  }
  $sortedequip = array();
  $sortedsig = array();
  for ($i = 0; $i < 16; $i++) {
    switch ($i) {
      case 0:
        $sortedequip[0] = $equipment[$i];
        $sortedsig[0] = $equipsig[$i];
        break;
      case 1:
        $sortedequip[1] = $equipment[$i];
        $sortedsig[1] = $equipsig[$i];
        break;
      case 2:
        $sortedequip[2] = $equipment[$i];
        $sortedsig[2] = $equipsig[$i];
        break;
      case 3:
        $sortedequip[3] = $equipment[$i];
        $sortedsig[3] = $equipsig[$i];
        break;
      case 4:
        $sortedequip[4] = $equipment[$i];
        $sortedsig[4] = $equipsig[$i];
        break;
      case 5:
        $sortedequip[5] = $equipment[9];
        $sortedsig[5] = $equipsig[9];
        break;
      case 6:
        $sortedequip[6] = $equipment[11];
        $sortedsig[6] = $equipsig[11];
        break;
      case 7:
        $sortedequip[7] = $equipment[12];
        $sortedsig[7] = $equipsig[12];
        break;
      case 8:
        $sortedequip[8] = $equipment[5];
        $sortedsig[8] = $equipsig[5];
        break;
      case 9:
        $sortedequip[9] = $equipment[6];
        $sortedsig[9] = $equipsig[6];
        break;
      case 10:
        $sortedequip[10] = $equipment[13];
        $sortedsig[10] = $equipsig[13];
        break;
      case 11:
        $sortedequip[11] = $equipment[14];
        $sortedsig[11] = $equipsig[14];
        break;
      case 12:
        $sortedequip[12] = $equipment[15];
        $sortedsig[12] = $equipsig[15];
        break;
      case 13:
        $sortedequip[13] = $equipment[10];
        $sortedsig[13] = $equipsig[10];
        break;
      case 14:
        $sortedequip[14] = $equipment[7];
        $sortedsig[14] = $equipsig[7];
        break;
      case 15:
        $sortedequip[15] = $equipment[8];
        $sortedsig[15] = $equipsig[0];
        break;
    }
  }
  $compiled['equip'] = $sortedequip;
  $compiled['equipsig'] = $sortedsig;
  // get current race/sex/face
  $char_look = sqlQuery("SELECT face, race FROM `char_look` WHERE charid = ".$charid);
  $char_img = "";
  $char_race = "";
  switch ($char_look['race']) {
    default:
    case 1:
      $char_img = "images/mini_face/hh";
      $char_race = "H&#9794;";
      break;
    case 2:
      $char_img = "images/mini_face/h";
      $char_race = "H&#9792;";
      break;
    case 3:
      $char_img = "images/mini_face/ee";
      $char_race = "E&#9794;";
      break;
    case 4:
      $char_img = "images/mini_face/e";
      $char_race = "E&#9792;";
      break;
    case 5:
      $char_img = "images/mini_face/t";
      $char_race = "T&#9794;";
      break;
    case 6:
      $char_img = "images/mini_face/tt";
      $char_race = "T&#9792;";
      break;
    case 7:
      $char_img = "images/mini_face/m";
      $char_race = "M&#9792;";
      break;
    case 8:
      $char_img = "images/mini_face/g";
      $char_race = "G&#9794;";
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
    if ($row['stack']) {
      $stackSize = sqlQuery("SELECT stackSize FROM `item_basic` WHERE itemid = ".$row['itemid'])["stackSize"];
      $ah[$z]['quantity'] = $stackSize;
    } else {
      $ah[$z]['quantity'] = 1;
    }
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
    //$timestamp = new DateTime(date("m/d/Y h:i:s",$row['sell_date']));
    //$ah[$z]['date'] = trim($timestamp->format("m/d/Y h:ia"), "m");
	$timestamp = new DateTime(date("Y-m-d H:i:s",$row['sell_date']));
	$ah[$z]["date"] = trim($timestamp->format("m/d/Y h:ia"), "m");
    $z++;
  }
  $compiled['ah'] = $ah;
  // bazaar
  $sql = "SELECT itemId, quantity, bazaar, signature FROM `char_inventory` WHERE charid = ".$charid." AND bazaar > 0 ORDER BY `char_inventory`.`bazaar` DESC";
  $bazaar = array();
  $z = 0;
  $tmp = mysqli_query($dcon, $sql);
  while ($row = $tmp->fetch_assoc()) {
  	$bazaar[$z]['itemid'] = $row['itemId'];
    $itemname = ucwords(sqlQuery("SELECT realname FROM `item_info` WHERE itemid = ".$row['itemId'])['realname']);
    $itemname = str_replace("The", "the", str_replace("Of", "of", $itemname));
    $bazaar[$z]['itemname'] = $itemname;
  	$bazaar[$z]['quantity'] = $row['quantity'];
  	$bazaar[$z]['price'] = number_format($row['bazaar']);
  	$bazaar[$z]['signature'] = $row['signature'];
  	$ahprice = sqlQuery("SELECT sale FROM `auction_house` WHERE seller_name = 'DarkStar' AND buyer_name = 'DarkStar' AND itemid = ".$row['itemId'])["sale"];
  	$ahprice = $ahprice - $row['bazaar'];
  	$bazaar[$z]['ahprice'] = $ahprice;
  	$z++;
  }
  $compiled['bazaar'] = $bazaar;
 }

$json = json_encode($compiled);
echo $json;

?>