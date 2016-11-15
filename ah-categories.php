<?php

$clock = true;
#require("include/html.inc");

htmlHeader();
htmlDropDown(1);

echo <<<EOF
    </div>
    <div id="content">

EOF;

  //
  // Auction House
  //
echo <<<EOF
      <table class="tbl tbl-ahcats">
        <thead><tr class="tbl-head">
          <th colspan="3" id="ahcat"><i class="fa fa-balance-scale" aria-hidden="true"></i> Auction House - Categories</th>
        </tr></thead>
        <tbody><tr>
          <td><table><tr>
            <td>Weapons</td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="1"><span>Hand to Hand</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="2"><span>Daggers</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="3"><span>Swords</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="4"><span>Great Swords</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="5"><span>Axes</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="6"><span>Great Axes</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="7"><span>Scythes</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="8"><span>Polearms</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="9"><span>Katana</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="10"><span>Great Katana</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="11"><span>Clubs</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="12"><span>Staves</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="13"><span>Ranged</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="14"><span>Instuments</span></a></td>
          </tr><tr>
            <td class="indent">Ammo & Misc</td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id=""><span>Pet Items</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id=""><span>Fishing Gear</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="15"><span>Ammunition</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id=""><span>Grips</span></a></td>
          </tr><tr>
            <td>Armour</td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="16"><span>Shields</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="17"><span>Head</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="22"><span>Neck</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="18"><span>Body</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="19"><span>Hands</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="23"><span>Waist</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="20"><span>Legs</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="21"><span>Feet</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="26"><span>Back</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="24"><span>Earrings</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="25"><span>Rings</span></a></td>
          </tr><tr>
            <td>Scrolls</td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="28"><span>White Magic</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="29"><span>Black Magic</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="32"><span>Songs</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="31"><span>Ninjutsu</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="30"><span>Summoning</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="60"><span>Dice</span></a></td>
          </tr></table>
          </td><td>&nbsp; &nbsp;</td><td style="vertical-align:top;">
          <table><tr>
            <td><a class="link catlink" data-id="33"><span>Medicines</span></a></td>
          </tr><tr>
            <td><a class="link catlink" data-id="34"><span>Furnishings</span></a></td>
          </tr><tr>
            <td>Materials</td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="44"><span>Alchemy</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="42"><span>Bonecraft</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="40"><span>Clothcraft</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="39"><span>Goldsmithing</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="41"><span>Leathercraft</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="38"><span>Smithing</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="43"><span>Woodworking</span></a></td>
          </tr><tr>
            <td>Food</td>
          </tr><tr>
            <td class="indent">Meals</td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="52"><span>Meat & Eggs</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="53"><span>Seafood</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="54"><span>Vegetables</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="55"><span>Soups</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="56"><span>Bread & Rice</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="57"><span>Sweets</span></a></td>
          </tr><tr>
            <td class="indent2"><a class="link catlink" data-id="58"><span>Drinks</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="59"><span>Ingredients</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="51"><span>Fish</span></a></td>
          </tr><tr>
            <td><a class="link catlink" data-id="35"><span>Crystals</span></a></td>
          </tr><tr>
            <td>Others</td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="46"><span>Misc</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="50"><span>Beast-Made</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="36"><span>Cards</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="49"><span>Ninja Tools</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="37"><span>Cursed Items</span></a></td>
          </tr><tr>
            <td class="indent"><a class="link catlink" data-id="61"><span>Automatons</span></a></td>
          </tr></table></td>
        </tr></tbody>
      </table>
EOF;
  // Footer
echo "      <div id=\"toTop\"><i class=\"fa fa-caret-square-o-up\" aria-hidden=\"true\"></i></div>";
echo "    </div>";
htmlFooter("ah");

?>