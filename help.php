<?php

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");

htmlHeader();
htmlDropDown(4);

echo <<<EOF
    </div>
    <div id="content">
      <table class="tbl tbl-text">
        <thead><tr class="tbl-head">
          <th>FAQ</th>
        </tr></thead>
        <tbody><tr>
          <td>
            <b>How Does This Server Differ From Retail?</b><br/>
            We have made many changes to the playstyle of FFXI to be more fitting for this day in age. The full list of core game changes is as follows:<br/><br/>
            <ul style="margin-left: 22px">
              <li style="disc">NO EXP Loss on Death!</li>
              <li style="disc">EXP Rate x4.0 (Default: x1.0)</li>
              <li style="disc">Fame Multiplier x2.00 (Default: x1.00)</li>
              <li style="disc">Speed Modifier: +30</li>
              <li style="disc">HP/MP while Resting: +20/24 (Default: +10/12)</li>
              <li style="disc">Seconds between healing ticks: 4 (Default: 10)</li>
              <li style="disc">Crafting Skillup Multiplier: x6.0 (Default: x1.0)</li>
              <li style="disc">FoV/Tabs EXP Rate: x8.0 (Default: x1.0)</li>
              <li style="disc">FoV/GoV Level Restriction Removed!</li>
              <li style="disc">All Combat/Magic Skills Auto-Cap on Level Up/Down</li>
              <li style="disc">NM ???-pop Reset Time: 30s (Default: 300s)</li>
              <li style="disc">Starting Gil: 1,000,000</li>
              <li style="disc">Gil / Kill Modifier: 420</li>
              <li style="disc">CoP Level Cap Removed!</li>
            </ul>
            <br/>
          </td>
        </tr><tr>
          <td>
            <b>What Special Commands Are Available on AfterHours?</b><br/>
            Given that we run a private server we have provided access to a variety of commands to help you in your time in Vana'diel.<br/><br/>
            <ul style="margin-left: 22px">
              <li style="disc"><span>@ah</span> : Access the Auction House from anywhere!</li>
              <li style="disc"><span>@chocobo</span> : Instantly mount a chocobo.</li>
              <li style="disc"><span>@escape</span> : Cast the ESCAPE spell on your party.</li>
              <li style="disc"><span>@goto &lt;char&gt;</span> : Teleport to specified character.</li>
              <li style="disc"><span>@homepoint</span> : Teleport to your homepoint.</li>
              <li style="disc"><span>@mogshop &lt;#&gt;</span> : Access a given moogle shop.</li>
              <li style="disc"><span>@raise &lt;level&gt; &lt;char&gt;</span> : Raise specified character.</li>
              <li style="disc"><span>@regen</span> : Grant character Protect, Shell, Regen, Refresh & Haste.</li>
              <li style="disc"><span>@signet</span> : Grant character signet.</li>
              <li style="disc"><span>@wallhack</span> : Walk through walls (toggle).</li>
            </ul>
            <br/>
          </td>
        </tr><tr>
          <td>
            <b>What Jobs *DO NOT* Work?</b><br/>
            Please do not play Puppetmaster, Runefencer or Geomancer as these are extremely buggy at the moment and will likely crash the server.<br/><br/>
          </td>
        </tr><tr>
          <td>
            <b>What Mobs Should I Leave Along?</b><br/>
            Anything that charms. This includes Pandemonium Warden, Vrtra, etc.<br/><br/>
          </td>
        </tr><tr>
          <td>
            <b>Which BCNM/KSNM/etc. Work?</b><br/>
            Please refer to the official Darkstar list <a href="https://github.com/DarkstarProject/darkstar/issues/2782">here <i class="fa fa-external-link" aria-hidden="true"></i></a>.<br/><br/>
          </td>
        </tr><tr>
          <td>
            <b>Whats the Auction House Status?</b><br/>
            The AH is automatically rechecked & restocked every few minutes, the going rate for an item can be seen in the Price History. Items posted for the going rate will be automatically purchased by the AH script.<br/><br/>
          </td>
        </tr><tr>
          <td>
            <b>How Can I Talk With Others?</b><br/>
            While we do have an 'AfterHours' linkshell, I have also enabled /say to be serverwide (it will show up like a unity message).<br/><br/>
          </td>
        </tr></tbody>
      </table>
EOF;

// Footer
echo "    </div>";
htmlFooter("item");

?>