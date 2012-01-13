<?php
error_reporting(E_ALL);

function get_connection()
{

	// List of PDO drivers:  http://www.php.net/manual/en/pdo.drivers.php
	
	// mysql dsn setup
	/*
	$username = 'password';
	$password = 'username';
	$database = 'databaseName';
	$host = 'host=ipAddressOrWebAddressOfServer';

	$dsn = 'mysql:dbname=' . $database . ';host='. $host;
	
	$dbh = new PDO($dsn, $username, $password, array(PDO::ATTR_PERSISTENT => true)); // connection pooling
	return $dbh;
	*/
	
	// SQLite
	$dbh = new PDO("sqlite:/Full/Path/To/example-sqlite.sdb");
	$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	return $dbh;
}

?>