<?php

$clock = true;
require("include/html.inc");

htmlHeader();
htmlDropDown(0);
echo <<<EOF

<!--      <h2>
        <i class="fa fa-refresh" aria-hidden="true"></i> Online <span class='totalOnline'></span> &nbsp;
        <a href="/db/"><i class="fa fa-database" aria-hidden="true"></i></a> &nbsp;
        <a href="/users/"><i class="fa fa-users" aria-hidden="true"></i></a> &nbsp;
        <a href="/download/"><i class="fa fa-download" aria-hidden="true"></i></a> &nbsp;
        <a href="/help/"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
      </h2>-->
    </div>
    <div id="content">
      <div>
      <table class="tbl tbl-hover" id="tbl-online">
        <thead><tr class="tbl-head">
          <th>Player <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th>Area <i class="fa fa-unsorted" aria-hidden="true"></i></th>
          <th>Job <i class="fa fa-unsorted" aria-hidden="true"></i></th>
        </tr></thead>
        <tbody id="online"></tbody>
      </table>
      </div>
      <br/>
      <form method="get" class="searchBox" action="/search.php">
        <input class="home-search searchBoxInput" type="text" autocomplete="off" name="id" size="32" placeholder="Search here..."><br/>
        <i class="fa fa-search submit" aria-hidden="true"></i>
      </form>
    </div>
EOF;
htmlFooter();

?>