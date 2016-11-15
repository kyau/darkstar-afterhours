<?php

$jobs = array("","WAR","MNK","WHM","BLM","RDM","THF","PLD","DRK","BST","BRD","RNG","SAM","NIN","DRG","SMN","BLU","COR","PUP","DNC","SCH");

$clock = true;
require("include/html.inc");

htmlHeader();
htmlDropDown(4);

echo <<<EOF
    </div>
    <div id="content">
      <table class="tbl tbl-text tbl-hover">
        <thead><tr class="tbl-head">
          <th>AfterHours Download</th>
        </tr></thead>
        <tbody><tr>
          <!--<td style="padding: 4px 10px; font-size: 12pt"><i class="fa fa-cube fa-pulse fa-fw"></i> Coming Soon...</td>-->
          <td><b>Prerequisites</b><br/>
            <ul style="margin-left: 22px">
              <li style="disc"><a href="magnet:?xt=urn:btih:369f0aa8bfcc10d17c489777e9e86e4ba731c5b3&dn=Final+Fantasy+XI+Ultimate+Collection+Seekers+Edition+FFXI&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969&tr=udp%3A%2F%2Fzer0day.ch%3A1337&tr=udp%3A%2F%2Fopen.demonii.com%3A1337&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969&tr=udp%3A%2F%2Fexodus.desync.com%3A6969">FFXI Ultimate Collection <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
              <li style="disc"><a href="http://www.microsoft.com/en-us/download/details.aspx?id=30679">Visual C++ Redistributable for Visual Studio 2012 Update 4 <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
              <li style="disc"><a href="http://www.microsoft.com/en-us/download/details.aspx?id=40784">Visual C++ Redistributable Packages for Visual Studio 2013 <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
              <li style="disc"><a href="http://www.microsoft.com/en-us/download/details.aspx?id=48145">Visual C++ Redistributable for Visual Studio 2015 <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            </ul>
            <div class="center"><i>NOTE: For 64-bit OS you need both 32-bit & 64-bit.</i></div>
          </td>
        </tr><tr>
          <td><br/><b>PlayOnline / Final Fantasy XI</b></td>
        </tr><tr>
          <td><b>1.</b> Install PlayOnline and Final Fantasy XI by launching FFXISETUP.exe and installing every expansion.</td>
        </tr><tr>
          <td><b>2.</b> Download <a href="/files/update.zip">update.zip <i class="fa fa-external-link" aria-hidden="true"></i></a> and extract all of its contents into your FFXI install folder (eg. C:\Program Files\PlayOnline\SquareEnix\Final Fantasy XI), overwriting any current versions.</td>
        </tr><tr>
          <td><b>3.</b> Launch PlayOnline (it will update and restart itself this is normal), select `Existing Members` and enter `ABCD1234` as the `Member Name` and `PlayOnline ID`. Do *NOT* login!</td>
        </tr><tr>
          <td><b>4.</b> Select the `Check Files` option on the left, then select `FINAL FANTASY XI` from the dropdown menu. Then click `Check Now`, this process will take a *very* long time depending on your computer and/or internet connection. (It is quite possible it will take a few hours)</td>
        </tr><tr>
          <td><b>5.</b> Finally open up the `PlayOnlineViewer` folder (eg. C:\Program Files\PlayOnline\SquareEnix\PlayOnlineViewer) and navigate into the `data` folder. You need to copy everything in here into your main FFXI folder (the same one you extracted the update.zip into).</td>
        </tr><tr>
          <td><br/><b>Ashita2</b><br/></td>
        </tr><tr>
          <td><b>1.</b> Download and run <a href="http://delvl.ffevo.net/atom0s/launcher-v2/raw/master/Ashita.exe">Ashita2 <i class="fa fa-external-link" aria-hidden="true"></i></a>.</td>
        </tr><tr>
          <td><b>2.</b> Click the `+` button to add a new profile.</td>
        </tr><tr>
          <td><b>3.</b> Enter `.\\ffxi-bootmod\\pol.exe` for the `BOOT FILE`.</td>
        </tr><tr>
          <td><b>4.</b> Enter `--server dark.kyau.net` for the `BOOT COMMAND`.</td>
        </tr><tr>
          <td><b>5.</b> Select the `Window` tab at the top in order to set your default game resolution.</td>
        </tr><tr>
          <td><b>6.</b> When finished you can click the chain icon at the bottom to create a desktop shortcut for the AfterHours profile.</td>
        </tr></tbody>
      </table>
EOF;

// Footer
echo "      <div id=\"toTop\"><i class=\"fa fa-caret-square-o-up\" aria-hidden=\"true\"></i></div>";
echo "    </div>";
htmlFooter("item");

?>