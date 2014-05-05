<?php


if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	echo '
	<ul>
	<li><a href="account.php">Account Home</a></li>
	<li><a href="user_settings.php">User Settings</a></li>
	<li><a href="logout.php">Logout</a></li>
	<li><form enctype="multipart/form-data" action="encrypt.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
	Enter Pass-Phrase:<input type="text" name="passphrase" /></br>
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Submit" />
</form></br></br></br>
<form enctype="multipart/form-data" action="decrypt.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Submit" />
</form></li>
	</ul>';
	
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2))){
	echo "
	<ul>
	<li><a href='admin_configuration.php'>Admin Configuration</a></li>
	<li><a href='admin_users.php'>Admin Users</a></li>
	<li><a href='admin_permissions.php'>Admin Permissions</a></li>
	<li><a href='admin_pages.php'>Admin Pages</a></li>
	</ul>";
	}
} 
//Links for users not logged in
else {
	echo "
	<ul>
	<li><a href='index.php'>Home</a></li>
	<li><a href='login.php'>Login</a></li>
	<li><a href='register.php'>Register</a></li>
	<li><a href='forgot-password.php'>Forgot Password</a></li>";
	if ($emailActivation)
	{
	echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
	}
	echo "</ul>";
}

?>
