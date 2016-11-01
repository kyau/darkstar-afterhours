<?php

/*
  db:`char_skills`
  // 0~12  combat skills
  // 13~21 unused
  // 22~45 magic skills
  // 46~47 unused
  SKILL_FISHING = 48,
  SKILL_WOODWORKING = 49,
  SKILL_SMITHING = 50,
  SKILL_GOLDSMITHING = 51,
  SKILL_CLOTHCRAFT = 52,
  SKILL_LEATHERCRAFT = 53,
  SKILL_BONECRAFT = 54,
  SKILL_ALCHEMY = 55,
  SKILL_COOKING = 56,
  SKILL_SYNERGY = 57,
  SKILL_RID = 58,
  SKILL_DIG = 59

  db:`char_look`
  Hume (Male) = 1,
  Hume (Female) = 2,
  Elvaan (Male) = 3,
  Elvaan (Female) = 4,
  Tarutaru (Male) = 5,
  Tarutaru (Female) = 6,
  Mithra = 7,
  Galka = 8
*/

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");

if (isset($_GET['id'])) {
  htmlHeader(trim($_GET['id'], "/"));
  htmlDropDown(2);

  echo <<<EOF
    </div>
    <div id="content">

EOF;
  //
  // Character Stats
  //
  echo <<<EOF
    <table class="tbl tbl-stats tbl-hover">
      <thead><tr class="tbl-head">
        <th>Profile</th>
      </tr></thead>
      <tbody><tr>
        <td></td>
      </tr><tr>
        <td><h3 id="auto_name">XXX</h3></td>
      </tr><tr>
        <td><h3 id="auto_linkshell" class="linkshell">&lt;N/A&gt;</h3></td>
      </tr><tr>
        <td style="padding-bottom:3px !important"><span id="auto_zone">NULL</span></td>
      </tr><tr>
        <td><img id="auto_img" class="mini-icon" src="" /> <span id="auto_race"></span></td>
      </tr><tr>
        <td><img class="mini-icon" src="images/bastok.png" /> <span id="auto_rank_bastok">0</span> &nbsp; <img class="mini-icon" src="images/sandoria.png" /> <span id="auto_rank_sandoria">0</span> &nbsp; <img class="mini-icon" src="images/windurst.png" /> <span id="auto_rank_windurst">0</span></td>
      </tr><tr>
        <td><img class="mini-icon" src="images/icons/15194.png" /> <span id="auto_maat">0</span>/15</td>
      </tr><tr>
        <td class="separator"></td>
      </tr><tr>
        <td><img class="mini-icon" src="images/icons/65535.png" /> <span id="auto_gil">0</span></td>
      </tr><tr>
        <td></td>
      </tr></tbody>
    </table>
EOF;
  //
  // Equipment
  //
  echo <<<EOF

      <div class="player-equipbox">
        <div class="player-equipbox-head">Equipment</div>
EOF;
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
    echo "        <div id=\"auto_equip".$slot."\" class=\"equipslot\"><img src=\"images/eq".strval($i+1).".gif\"></div>";
  }
  echo <<<EOF
        <div class="player-equipbox-footer"><span id="auto_mainjob">JOB00</span><span id="auto_subjob">JOB00</span></div>
      </div>
      <br/><br/>
EOF;

  //
  // Crafting
  //
  echo <<<EOF
    <table class="tbl tbl-crafts tbl-hover">
      <thead><tr class="tbl-head">
        <th colspan="2">Crafting</th>
      </tr></thead>
      <tbody><tr>
        <td>Smithing</td>
        <td id="auto_smithing" class="right">0.0</td>
      </tr><tr>
        <td>Clothcraft</td>
        <td id="auto_clothcraft" class="right">0.0</td>
      </tr><tr>
        <td>Alchemy</td>
        <td id="auto_alchemy" class="right">0.0</td>
      </tr><tr>
        <td>Woodworking</td>
        <td id="auto_woodworking" class="right">0.0</td>
      </tr><tr>
        <td>Goldsmithing</td>
        <td id="auto_goldsmithing" class="right">0.0</td>
      </tr><tr>
        <td>Leathercrafting</td>
        <td id="auto_leathercraft" class="right">0.0</td>
      </tr><tr>
        <td>Bonecraft</td>
        <td id="auto_bonecraft" class="right">0.0</td>
      </tr><tr>
        <td>Cooking</td>
        <td id="auto_cooking" class="right">0.0</td>
      </tr><tr>
        <td>Fishing</td>
        <td id="auto_fishing" class="right">0.0</td>
      </tr><tr>
        <td>Synergy</td>
        <td id="auto_synergy" class="right">0.0</td>
      </tr></tbody>
    </table>
EOF;
  //
  // Missions
  //
  echo <<<EOF
      <table class="tbl tbl-mission tbl-hover">
        <thead><tr class="tbl-head">
          <th colspan="2">Missions</th>
        </tr></thead>
        <tbody><tr>
          <td>Zilart</td>
          <td id="auto_mission1" align="right">N/A</td>
        </tr><tr>
          <td>Promathia</td>
          <td id="auto_mission2" align="right">N/A</td>
        </tr><tr>
          <td>ToAU</td>
          <td id="auto_mission3" align="right">N/A</td>
        </tr><tr>
          <td>Assault</td>
          <td id="auto_mission4" align="right">N/A</td>
        </tr><tr>
          <td>Altana</td>
          <td id="auto_mission5" align="right">N/A</td>
        </tr><tr>
          <td>Campaign</td>
          <td id="auto_mission6" align="right">N/A</td>
        </tr><tr>
          <td>C.Prophecy</td>
          <td id="auto_mission7" align="right">N/A</td>
        </tr><tr>
          <td>M.KupoD'etat</td>
          <td id="auto_mission8" align="right">N/A</td>
        </tr><tr>
          <td>S.Ascension</td>
          <td id="auto_mission9" align="right">N/A</td>
        </tr></tbody>
      </table>
EOF;
  //
  // Jobs
  //
  echo <<<EOF
    <table class="tbl tbl-jobs tbl-hovertd">
      <thead><tr class="tbl-head">
        <th colspan="2">Jobs</th>
      </tr></thead>
      <tbody><tr>
        <td><span style="float:left">WAR</span>
        <span id="auto_war" style="float:right">0</td>
        <td><span style="float:left">MNK</span>
        <span id="auto_mnk" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">WHM</span>
        <span id="auto_whm" style="float:right">0</td>
        <td><span style="float:left">BLM</span>
        <span id="auto_blm" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">RDM</span>
        <span id="auto_rdm" style="float:right">0</td>
        <td><span style="float:left">THF</span>
        <span id="auto_thf" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">PLD</span>
        <span id="auto_pld" style="float:right">0</td>
        <td><span style="float:left">DRK</span>
        <span id="auto_drk" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">BST</span>
        <span id="auto_bst" style="float:right">0</td>
        <td><span style="float:left">BRD</span>
        <span id="auto_brd" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">RNG</span>
        <span id="auto_rng" style="float:right">0</td>
        <td><span style="float:left">SAM</span>
        <span id="auto_sam" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">NIN</span>
        <span id="auto_nin" style="float:right">0</td>
        <td><span style="float:left">DRG</span>
        <span id="auto_drg" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">SMN</span>
        <span id="auto_smn" style="float:right">0</td>
        <td><span style="float:left">BLU</span>
        <span id="auto_blu" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">COR</span>
        <span id="auto_cor" style="float:right">0</td>
        <td><span style="float:left">PUP</span>
        <span id="auto_pup" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">DNC</span>
        <span id="auto_dnc" style="float:right">0</td>
        <td><span style="float:left">SCH</span>
        <span id="auto_sch" style="float:right">0</td>
      </tr><tr>
        <td><span style="float:left">GEO</span>
        <span id="auto_geo" style="float:right">0</td>
        <td><span style="float:left">RUN</span>
        <span id="auto_run" style="float:right">0</td>
      </tr></tbody>
    </table>
EOF;
  echo "      <br/><br/>";
  //
  // Auction House
  //
  echo <<<EOF
      <table class="tbl tbl-ah tbl-hover">
        <thead><tr class="tbl-head">
          <th colspan="6">Auction House</th>
        </tr>
        <tr class="tbl-subhead">
          <td>&nbsp;</td>
          <td class="ah-item">Item</td>
          <td class="ah-date">Date</td>
          <td class="ah-who">Seller</td>
          <td class="ah-who">Buyer</td>
          <td class="ah-price">Price</td>
        </tr></thead>
        <tbody id="auctions">
        </tbody>
      </table>
EOF;
  // Footer
  echo "    </div>";
  htmlFooter("char");
} else {
  header('Location: https://ffxi.kyau.net:4444/');
}

?>