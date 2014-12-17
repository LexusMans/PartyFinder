<?php
$db_conx = mysqli_connect("dbhost-mysql.cs.missouri.edu", "lem346", "9ErVF9vM", "lem346");

// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
