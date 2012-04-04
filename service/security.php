<?php

require_once("connection_info.php");

// NOTE: basic auth does not work when php is running in cgi mode.
// To work around this use the htaccess file or add the line in
// it to your own htaccess file.  Remember to rename it to .htaccess.

function do_login_basic(){	
	
	$username = null;
	$password = null;

	if (isset($_SERVER['PHP_AUTH_USER'])) {
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
	} 
	elseif (isset($_SERVER['HTTP_AUTHORIZATION'])){ 
		// php in cgi mode.  using .htaccess file rewrite
		list($username, $password) = 
			explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

		if( strlen($username) == 0 || strlen($password) == 0 )
		{
			return false;
		}
	}
	else {
		return false;
	}

	// This is were you should check against you user database if the
	// username and password combination is correct.
	if ($username == "testuser" and $password == "testpassword"){
		return true;
	}

	return false;
}



?>
