<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'myDB');
define('DB_USER','root');
define('DB_PASSWORD','mysql');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

// Make users the current database
$db = mysql_select_db('users', $con);

if (!$db) {
  // If we couldn't, then it either doesn't exist, or we can't see it.
	$sql = 'CREATE DATABASE users';
	
	if (mysql_query($sql, $con)) {
	//	echo "Database organizations created successfully\n";
		$db = mysql_select_db('users', $con);
	} else {
		echo 'Error creating database: ' . mysql_error() . "\n";
	}
}
$account_type = $_POST['account_type'];
//if($_POST['account_type'] == 'Organization'){
//	$account_type = 'organization';
//}

$query = sprintf("SELECT %s FROM users.tables",mysql_real_escape_string($account_type));
$resultq = mysql_query($query, $con);
$query = sprintf("CREATE TABLE %s(
email VARCHAR(255) NOT NULL PRIMARY KEY,
name VARCHAR(40) NOT NULL,
address VARCHAR(255) NOT NULL,
pass VARCHAR(40) NOT NULL,
reg_time VARCHAR(40) NOT NULL,
token INT(255) NOT NULL)",mysql_real_escape_string($account_type));
mysql_query($query, $con);

function Register($account_type)
{

session_start();   //starting the session for user profile page
if(!empty($_POST['name']) and !empty($_POST['email']) and !empty($_POST['password']))   //checking the 'user' name which is from Sign-In.html, is it empty or have some text
{
	$queryStr = sprintf("SELECT *  FROM %s where email = '%s'", mysql_real_escape_string($account_type), mysql_real_escape_string($_POST[email]));
	$query = mysql_query($queryStr) or die(mysql_error());
	$row = mysql_fetch_array($query);
	if(empty($row['email']))
	{
		//$date = new DateTime();
		$date_str = strval(mt_rand());

		$hash = crypt($_POST['password'], $date_str);

		//$key = rand(0,100000);
		$key = 0;
		if($account_type == 'student'){
		$sql = sprintf("INSERT INTO %s (email, name, address, pass, reg_time, token) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",mysql_real_escape_string($account_type),
			mysql_real_escape_string($_POST[email]),
			mysql_real_escape_string($_POST[name]),
			mysql_real_escape_string($_POST[address]),
			mysql_real_escape_string($hash),
			mysql_real_escape_string($date_str),
			mysql_real_escape_string($key));
		}else{
			$sql = sprintf("INSERT INTO %s (email, name, pass, reg_time, token) VALUES ('%s', '%s', '%s', '%s', '%s')",mysql_real_escape_string($account_type),mysql_real_escape_string($_POST[email]),mysql_real_escape_string(str_replace(' ', '', $_POST[name])),mysql_real_escape_string($hash),mysql_real_escape_string($date_str),mysql_real_escape_string($key));
		}

		if(mysql_query($sql) or die(mysql_error())){
			echo "registered.html"; // Redirect browser to registration confirmed page 
			exit();
		} else{
			echo "ERROR: Could not able to execute $sql. ";
		}
	}
	else
	{
		echo "This account already exists!";
	}
}
else{
	echo "Must fill out all of form";
}
}

Register($account_type);


?>
