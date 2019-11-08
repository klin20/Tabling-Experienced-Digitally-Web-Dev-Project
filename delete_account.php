<!-- 
<!DOCTYPE HTML>
<html>
<head>
	<title>Team Celeste BOI</title>
	<link rel="stylesheet" type="text/css" href="style-sign.css">

 <script type="text/javascript" language="javascript">
 function submitform(){
 document.getElementById('myForm').submit();
 }
 
 </script>


</head> -->

<?php
define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PASSWORD','mysql');


$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$organization = $_COOKIE["name"];

if($_COOKIE['account_type']=='organization'){
$query1 = sprintf("SELECT * FROM users.organization WHERE 
	email LIKE '%s'", mysql_real_escape_string($organization));
}else{
$query1 = sprintf("SELECT * FROM users.student WHERE email LIKE '%s'", mysql_real_escape_string($organization));
}
$result5 = mysql_query($query1) or die(mysql_error());
$row = mysql_fetch_array($result5);
$organization54 = $row['name'];
$organization = str_replace(' ', '', $organization54);


// Make users the current database
session_start();




if($_COOKIE['account_type']=='organization'){
	$db = mysql_select_db('organizations', $con);
	$query1 = "DROP TABLE $organization";
	$result5 = mysql_query($query1);
	$db = mysql_select_db('users', $con);
	$query9 = "DELETE FROM $_COOKIE[account_type] WHERE $_COOKIE[account_type].email='".$_COOKIE[name]."'";
	$result5 = mysql_query($query9) or die(mysql_error());

	setcookie("name", "", time() - 3600);
	setcookie("token", "", time() - 3600);
	setcookie("account_type", "", time() - 3600);
}else if($_COOKIE['account_type']=='student'){
	$db = mysql_select_db('shoppers', $con);
	$query2 = "DROP TABLE $organization";
	$result6 = mysql_query($query2);
	$db = mysql_select_db('users', $con);
	$query9 = "DELETE FROM $_COOKIE[account_type] WHERE $_COOKIE[account_type].email='".$_COOKIE[name]."'";
	$result5 = mysql_query($query9) or die(mysql_error());

	setcookie("name", "", time() - 3600);
	setcookie("token", "", time() - 3600);
	setcookie("account_type", "", time() - 3600);
}
?>

<!DOCTYPE html>
<html>
 <head>
 <title>ddddddelete</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <script type="text/javascript" language="javascript">
 function submitform(){
 document.getElementById('myForm').submit();
 }
 
 </script>
 
 </head>
 <body onload="submitform()">
 
 		<form method="GET" action="login.html" id="del_acc" name="del_acc">
      <input type="hidden" name="delete" value="yes"><br>
    </form>
 		  
 <script type="text/javascript" language="javascript">
 document.del_acc.submit();
 </script>
 			   
 </body>
 </html>