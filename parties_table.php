<html>
<head>
<title>Parties Table</title>
</head>
<body>

<?php
function print_results_in_table($result)
{
	echo "<table border=\"1\">";
	// Print table headers
	$row = mysqli_fetch_assoc($result);
	if (!$row)
		return FALSE;

	echo "<tr>";
	foreach($row as $key => $value)
		echo "<th>$key</th>";
		
	echo "</tr>";
	
	// Print the data from the first row, otherwise that data is lost 
	echo "<tr>";
	foreach($row as $res)
		echo "<td>$res</td>";
		
	echo "</tr>";

	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr>";
		foreach($row as $res)
			echo "<td>$res</td>";
			
		echo "</tr>";
	}
	
	echo "<\table>";
}
?>

<?php
	include_once("php_includes/db_conx.php");
	
	$sql = "SELECT * FROM parties";
	$result = mysqli_query($db_conx, $sql); 
	
	if(!$result)
		echo "Unable to execute query.";
	else
		echo "Query successful.</br></br>";

	print_results_in_table($result);
?>

</body>
</html>
