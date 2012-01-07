<?php
require_once("connection_info.php");
try
{
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

    foreach($result as $key=>$val)
    {
		// Notice that it is Product without an S
		$results[] = array('Product', array($key, $val));
    }
	
	header('Content-type: application/json');
	// Notice that it is Products with an S
	echo json_encode(array('Products'=>$results));
}
catch(Exception $e)
{
	print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>