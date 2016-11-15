<?php

$clock = true;
require("include/html.inc");

htmlHeader();
htmlDropDown(3);

echo <<<EOF
	</div>
	<div id="content">
		<div>
		<table class="tbl tbl-hover tbl-users" id="tbl-allusers">
			<thead><tr class="tbl-head">
				<th>&nbsp</th>
				<th>Player <i class="fa fa-unsorted" aria-hidden="true"></i></th>
				<th>Area <i class="fa fa-unsorted" aria-hidden="true"></i></th>
				<th>Job <i class="fa fa-unsorted" aria-hidden="true"></i></th>
			</tr></thead><tbody id="ajax">
		</tbody></table>
      	<div id="toTop"><i class="fa fa-caret-square-o-up" aria-hidden="true"></i></div>
		</div>
		<br/>
		<form method="get" class="searchBox" action="/search.php">
			<input class="home-search searchBoxInput" type="text" autocomplete="off" name="id" size="32" placeholder="Search here..."><br/>
			<i class="fa fa-search submit" aria-hidden="true"></i>
		</form>
	</div>
EOF;
htmlFooter("users");

?>