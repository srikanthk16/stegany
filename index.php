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
echo '<form enctype="multipart/form-data" action="encrypt.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
	Enter Pass-Phrase:<input type="text" name="passphrase" /></br>
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Submit" />
</form>
</div>
<div id="bottom"></div>
</div>
</body>
</html>';
?>