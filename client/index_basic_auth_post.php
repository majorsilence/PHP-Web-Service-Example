<?php


function get_data()
{

	// Basic Authentication
	$cred = sprintf("Authorization: Basic %s\r\n", base64_encode('testuser:testpassword') );

	// Use POST instead of GET to set parameter.
	$postdata = http_build_query(
            array(
                'limit' => '100'
    	    )
	);

	$opts = array('http' =>
		array(
		    'method'  => 'POST',
		    'header'  => $cred . "Content-type: application/x-www-form-urlencoded\r\n",
		    'content' => $postdata
		)
	);
	
	$context = stream_context_create($opts);
	// End POST parameter


	$url = "http://the-path-to-service.com/test_service_auth.php";
	$json_str = file_get_contents($url, false, $context);
	$json_obj = json_decode($json_str);
	
	foreach($json_obj as $value)
	{
		
		echo "<tr><td>" . $value->{'ProductID'} . "</td><td>";
		echo $value->{'ProductName'} . "</td><td>";
		echo $value->{'SupplierID'} . "</td><td>";
		echo $value->{'CategoryID'} . "</td><td>";
		echo $value->{'QuantityPerUnit'} . "</td><td>";
		echo $value->{'UnitPrice'} . "</td><td>";
		echo $value->{'UnitsInStock'} . "</td><td>";
		echo $value->{'UnitsOnOrder'} . "</td><td>";
		echo $value->{'ReorderLevel'} . "</td><td>";
		echo $value->{'Discontinued'} . "</td><td>";
		echo $value->{'DiscontinuedDate'} . "</td></tr>";
		
	}
}

?>

<html>
<head>
<title>Sample Client</title>
</head>
<body>
	<table border=1>
		<tr>
			<th>Product ID</th>
			<th>Product Name</th>
			<th>Supplier ID</th>
			<th>Category ID</th>
			<th>Quantity Per Unit</th>
			<th>Unit Price</th>
			<th>Units In Stock</th>
			<th>Units On Order</th>
			<th>Reorder Level</th>
			<th>Discontinued</th>
			<th>Discontinued Date</th>
		</tr>
		<?php
			get_data();
		?>
	</table>
</body>
</html>
