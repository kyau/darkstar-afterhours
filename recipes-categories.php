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
echo <<<EOF
          </table></td>
        </tr></tbody>
      </table>
EOF;
  // Footer
echo "      <div id=\"toTop\"><i class=\"fa fa-caret-square-o-up\" aria-hidden=\"true\"></i></div>";
echo "    </div>";
htmlFooter();

?>