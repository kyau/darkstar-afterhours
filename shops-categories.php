<?php

$clock = true;

htmlHeader();
htmlDropDown(2);

echo <<<EOF
    </div>
    <div id="content">
      <br/>

EOF;

  //
  // Shops List
  //
echo <<<EOF
      <table class="tbl tbl-ahcats">
        <thead><tr class="tbl-head">
          <th colspan="3" id="ahcat"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Custom Shops List</th>
        </tr></thead>
        <tbody><tr>
          <td><table><tr>
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
          </tr></table></td>
        </tr></tbody>
      </table>
EOF;
  // Footer
echo "    </div>";
htmlFooter();

?>