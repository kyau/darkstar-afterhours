<?php

$clock = true;
$crafts = array("Alchemy", "Bonecraft", "Clothcraft", "Cooking", "Goldsmithing", "Leathercraft", "Smithing", "Woodworking");
$craftss = array("alchemy", "bone", "cloth", "cook", "gold", "leather", "smith", "wood");
$ranks = array("Amateur", "Recruit", "Initiate", "Novice", "Apprentice", "Journeyman", "Craftsman", "Artisan", "Adept", "Veteran", "Expert", "Authority");

htmlHeader();
htmlDropDown(6);

echo <<<EOF
    </div>
    <div id="content">
      <br/>

EOF;

  //
  // Shops List
  //
echo <<<EOF
      <table class="tbl">
        <thead><tr class="tbl-head">
          <th id="ahcat"><i class="fa fa-diamond" aria-hidden="true"></i> Crafting Recipes</th>
        </tr></thead>
        <tbody><tr>
          <td><table>
EOF;
foreach ($crafts as $key => $value) {
  echo "<tr><td colspan=\"2\">".$value."</td></tr>";
  echo "<tr><td><img src=\"/images/crafting/".strtolower($value).".png\" /></td><td><table class=\"categories\"><tr>";
  foreach ($ranks as $key2 => $value2) {
    echo "<td><a class=\"recipelink blue\" data-craft=\"".$craftss[$key]."\" data-rank=\"".($key2 + 1)."\">".$value2."</a></td>";
    if ($key2 == 5)
      echo "</tr><tr>";
  }
  echo "</tr></table></td></tr>";
}
/*
          <tr>
            <td>Mogshops</td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="1"><span>Cystal Depot</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="2"><span>Pharmacy</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="3"><span>MogDonald's</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="4"><span>Tools</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="5"><span>National Hero Specials</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="6"><span>Mighty Hero Specials</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="7"><span>Chains-Breaker Specials</span></a></td>
          </tr></table>
          </td><td>&nbsp; &nbsp;</td><td style="vertical-align:top;">
          <table><tr>
            <td>Curio Vendor Moogles</td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="10"><span>AF1 Vendor</span></a></td>
<!--          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="11"><span>..</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link shoplink" data-id="12"><span>.</span></a></td> -->
*/
echo <<<EOF
          </table></td>
        </tr></tbody>
      </table>
EOF;
  // Footer
echo "    </div>";
htmlFooter();

?>