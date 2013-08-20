<?php
require_once("connection_info.php");
require("security.php");


// This will immediatly kill the script if the username
// password combination is wrong
try{
	if (false == do_login_basic())
	{
		header('WWW-Authenticate: Basic realm="Test Authentication"');
		header('HTTP/1.0 401 Unauthorized');
		echo "Failed to login";
		exit;
	}
}
catch(Exception $e){
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

try{
	$limit = $_REQUEST["limit"];
	if(!filter_var($limit, FILTER_VALIDATE_INT))
	{
		"Invalid ?limit value";
		exit();
	}

	$dbh = get_connection();
	
	$sql = 'SELECT ProductID, ProductName, SupplierID, CategoryID, QuantityPerUnit, UnitPrice, UnitsInStock, ';
	$sql = $sql . 'UnitsOnOrder, ReorderLevel, Discontinued, DiscontinuedDate FROM [Products] LIMIT :querylimit;';

	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':querylimit', $limit, PDO::PARAM_INT); 
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	header('Content-type: application/json');
	// Notice that it is Products with an S
	echo json_encode($result);
}
catch(Exception $e){
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

?>
