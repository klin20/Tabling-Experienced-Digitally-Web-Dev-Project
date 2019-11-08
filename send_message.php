<?php	
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'myDB');
	define('DB_USER','root');
	define('DB_PASSWORD','mysql');

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
	
	$sender = mysql_real_escape_string($_COOKIE["name"]);
	$sendertable = mysql_real_escape_string($_COOKIE["name"]);
	$sendertable = str_replace("@","At",$sendertable);
	$sendertable = str_replace(".","Dot",$sendertable);
	
	$receiver = mysql_real_escape_string($_POST["receiver"]);
	$receivertable = mysql_real_escape_string($_POST["receiver"]);
	$receivertable = str_replace("@","At",$receivertable);
	$receivertable = str_replace(".","Dot",$receivertable);
	
	$subject = mysql_real_escape_string($_POST["subject"]);
	
	$message = mysql_real_escape_string($_POST["message"]);
	
	$time = time();
	
	if(!mysql_select_db('messages', $con)){
		$sql = 'CREATE DATABASE messages';
		mysql_query($sql, $con);
		$db = mysql_select_db('messages', $con);
		//$query = sprintf("SELECT %s FROM messages.tables",mysql_real_escape_string($_COOKIE["name"]));
		//$resultq = mysql_query($query, $con);

//		if(mysql_query($query, $con)){
			//echo "Table created.";
//		} else {
//			echo "Failed to connect to MySQL: " . mysql_error();
//		}
	}
	
	$query = sprintf("CREATE TABLE %s(
			message_num INT(255) AUTO_INCREMENT NOT NULL PRIMARY KEY,
			sender VARCHAR(100) NOT NULL,
			receiver VARCHAR(100) NOT NULL,
			subject VARCHAR(100),
			sorr VARCHAR(100) NOT NULL,
			body TEXT,
			time INT NOT NULL)",$receivertable);
	mysql_query($query, $con);
	
	$sql = sprintf("INSERT INTO ".$receivertable."(sender, receiver, subject, body, sorr, time) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
		$sender, $receiver, $subject, $message, 'receive', $time);
	
	$sql2 = sprintf("INSERT INTO ".$sendertable."(sender, receiver, subject, body, sorr, time) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
	$sender, $receiver, $subject, $message, 'sent', $time);

	mysql_query($sql2) or die($sender);
	if(mysql_query($sql, $con)){
		header("Location: /messages.php");  
		exit();
	} else {
		echo  mysql_error();
	}
	
?>
