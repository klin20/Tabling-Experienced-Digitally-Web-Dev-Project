<?php
define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PASSWORD','mysql');


$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$organization = $_COOKIE["name"];
$query1 = "SELECT * FROM users.student WHERE email LIKE '$organization'";
$result5 = mysql_query($query1) or die(mysql_error());
$row = mysql_fetch_array($result5);
$organization54 = $row['name'];
$organization = str_replace(' ', '', $organization54);

mysql_select_db('messages');
$result = mysql_real_escape_string($_COOKIE["name"]);
$result = str_replace("@","At",$result);
$result = str_replace(".","Dot",$result);

// Make users the current database
$db = mysql_select_db('messages', $con);
session_start();


$query1 = "DELETE FROM $result WHERE sender LIKE '$_POST[sender]' AND receiver LIKE '$_POST[receiver]' AND subject LIKE '$_POST[subject]' AND sorr LIKE '$_POST[sorr]' AND  body LIKE '$_POST[body]' AND time LIKE '$_POST[time]'";

$result5 = mysql_query($query1) or die(mysql_error());

header("Location: /messages.php");
exit();
?>