<?php

$clock = true;
require("include/html.inc");

htmlHeader();
htmlDropDown(2);

echo <<<EOF
    </div>
    <div id="content">
    </div>
EOF;
htmlFooter("users");

?>