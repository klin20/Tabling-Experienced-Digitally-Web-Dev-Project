<?php
define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PASSWORD','mysql');


$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());


$result = mysql_real_escape_string($_COOKIE["name"]);
      $result = str_replace("@","At",$result);
      $result = str_replace(".","Dot",$result);

// Make users the current database
$db = mysql_select_db('orders', $con);
session_start();


$query1 = "DELETE FROM $result WHERE product LIKE '$_POST[product]' AND customername LIKE '$_POST[customername]' AND customeremail LIKE '$_POST[customeremail]' AND address LIKE '$_POST[address]' AND feature1 LIKE '$_POST[feature1]' AND feature2 LIKE '$_POST[feature2]' AND feature3 LIKE '$_POST[feature3]' AND feature4 LIKE '$_POST[feature4]' AND quantity LIKE '$_POST[quantity]'";

$result5 = mysql_query($query1) or die(mysql_error());

header("Location: /orders.php");
exit();
?>