<?php

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");

htmlHeader();
htmlDropDown(4);

echo <<<EOF
    </div>
    <div id="content">
      <table class="tbl tbl-hover">
        <thead><tr class="tbl-head">
          <th>AfterHours Download</th>
        </tr></thead>
        <tbody><tr>
          <td style="padding: 4px 10px; font-size: 12pt"><i class="fa fa-cube fa-pulse fa-fw"></i> Coming Soon...</td>
        </tr></tbody>
      </table>
EOF;

// Footer
echo "    </div>";
htmlFooter("item");

?>