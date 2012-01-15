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
		list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) =
			explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

		if( strlen($_SERVER['PHP_AUTH_USER']) == 0 || strlen($_SERVER['PHP_AUTH_PW']) == 0 )
		{
		    unset($_SERVER['PHP_AUTH_USER']);
		    unset($_SERVER['PHP_AUTH_PW']);	
			prompt_login('You must enter a username and password to use this service. Is this service running in CGI MODE?');
		}
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
	}
	else {
		prompt_login('No username and password entered.');
	}

	// This is were you should check against you user database if the
	// username and password combination is correct.
	if ($username != "testuser" and $password != "testpassword"){
		prompt_login("Incorrect username password combination.");
	}

}

function prompt_login($msg){
	header('WWW-Authenticate: Basic realm="Test Authentication"');
	header('HTTP/1.0 401 Unauthorized');
	echo $msg;
	exit;
}


?>
