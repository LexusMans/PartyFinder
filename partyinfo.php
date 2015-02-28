<!DOCTYPE html>
<html>
<head>
	<title>Party Info</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
<?php
$pid = $_POST["pid"];
if(!isset($pid)){
	header('Location: find.php');
}

include_once("template_navbar.php");
include_once("php_includes/db_conx.php");
$query = "SELECT * FROM parties WHERE id='$pid'";
$result = mysqli_query($db_conx, $query);
$row = mysqli_fetch_assoc($result);

$myDateTime = DateTime::createFromFormat('Y-m-d G:i:s', $row["start"]);
$newDateString = $myDateTime->format('l, F jS, Y g:i a');
/*
echo "<div class='container'><div class='panel panel-default'>
	<div class='panel-body'>
		<h3>".$row['title']."</h3>
	</div>
</div>";
*/
echo "<div class='container'>
	<div class='page-header'>
		<h1>".$row['title']."</h1>
	</div>";

echo "<div class='panel panel-default'>
	<div class='panel-heading'>".
		$newDateString
	."</div>
	<div class='panel-body'>".
			$row['address']
			."</br>".
			$row['city'] . ", " . $row['state'] . " " . $row['zipcode']
	."</div>
</div>";

if($row['pong'] == 1){
	echo "<span class='label label-info'>Beer Pong</span> ";
}
if($row['jj'] == 1){
	echo "<span class='label label-info'>Jungle Juice</span> ";
}
if($row['dj'] == 1){
	echo "<span class='label label-info'>DJ</span>";
}
echo "</br></br>";
echo "<div class='panel panel-default'>
	<div class='panel-body'>".
		$row['description']
	."</div>
</div></div>";

?>
</body>
</html>