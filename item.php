<?php

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");

if (isset($_GET['id'])) {
  if (isset($_GET['stack']))
    htmlHeader(trim($_GET['id'], "/"), $_GET['stack']);
  else
    htmlHeader(trim($_GET['id'], "/"));
  htmlDropDown(1);

  echo <<<EOF
    </div>
    <div id="content">
EOF;

  //
  // Character Stats
  //
  echo <<<EOF
    <table class="tbl tbl-item">
      <thead><tr class="tbl-head">
        <th colspan="2"><i class="fa fa-tag" aria-hidden="true"></i> Item</th>
      </tr></thead>
      <tbody><tr>
        <td colspan="2"></td>
      </tr><tr>
        <td class="item-icon"><img src="images/large-icons/18270.png" class="i_mainicon"></td>
        <td class="item">
          <span class="i_stack"></span><span class="i_raex"></span><div class="i_item">Name</div><div class="i_stats">&lt;stats&gt;</div><div class="i_jobs">&lt;jobs&gt;</div>
        </td>
      </tr><tr>
        <td colspan="2" style="height:1px"></td>
      </tr></tbody>
    </table>
EOF;

  //
  // Item Stats
  //
  echo <<<EOF
  <table class="tbl tbl-stats tbl-hover">
      <thead><tr class="tbl-head">
        <th><i class="fa fa-line-chart" aria-hidden="true"></i> Stats</th>
      </tr></thead>
      <tbody><tr>
        <td class="center"><span class="item-ahcat"></span></td>
      </tr><tr>
        <td class="center">In Stock: &nbsp;<span class="item-stock"></span></td>
      </tr><tr>
        <td class="center">Price: &nbsp;<span style="color:rgba(180,180,180,1);" class="item-currprice"></span></td>
      </tr><tr>
        <td class="center item-bgwiki"></td>
      </tr></tbody>
    </table>
    <br/><br/>
EOF;

  //
  // Auction House
  //
  echo <<<EOF
      <table class="tbl tbl-ah tbl-hover">
        <thead><tr class="tbl-head">
          <th colspan="6"><i class="fa fa-balance-scale" aria-hidden="true"></i> Price History<span id="price_history"></span></th>
        </tr>
        <tr class="tbl-subhead">
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
  htmlFooter("item");
} else {
  header('Location: https://ffxi.kyau.net:4444/');
}

?>