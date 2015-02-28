<?php
include_once("php_includes/db_conx.php");

$drop_query = "DROP TABLE IF EXISTS users, useroptions, parties, friends, blockedusers, status, photos, notifications";
$query = mysqli_query($db_conx, $drop_query);
if ($query === TRUE) {
	echo "<h3>Tables were dropped.</h3>"; 
} else {
	echo "<h3>Tables were NOT dropped.</h3>"; 
}
?>