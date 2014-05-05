<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>Stegany</h1>
<h6>A pure php steganography implementation</h6>
<div id='left-nav'>";
include("left-nav.php");
echo '
</div>
<div id="bottom"></div>
</div>
</body>
</html>';
?>