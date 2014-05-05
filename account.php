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
<h2>Account</h2>
<div id='left-nav'>";

include("left-nav.php");

echo "
</div>
<div id='main'>
Hey, $loggedInUser->displayname. This is an example of steganography with AES encryption, your title at the moment is $loggedInUser->title". date("M d, Y", $loggedInUser->signupTimeStamp()) . ".
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
