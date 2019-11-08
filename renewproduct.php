<?php
define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PASSWORD','mysql');


$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$organization = $_COOKIE["name"];
$query1 = "SELECT * FROM users.organization WHERE email LIKE '$organization'";
$result5 = mysql_query($query1) or die(mysql_error());
$row = mysql_fetch_array($result5);
$organization54 = $row['name'];
$organization = str_replace(' ', '', $organization54);



// Make users the current database
$db = mysql_select_db('organizations', $con);
session_start();


$query1 = "UPDATE $organization SET expires = '$_POST[expires]' WHERE product LIKE '$_POST[product]'";

$result5 = mysql_query($query1) or die(mysql_error());

header("Location: /archivedproducts.php");
exit();
?>