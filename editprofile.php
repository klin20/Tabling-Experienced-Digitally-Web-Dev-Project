<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'myDB');
define('DB_USER','root');
define('DB_PASSWORD','mysql');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

$db = mysql_select_db('users', $con);

$name= $_POST['name'];
$email= $_POST['oldemail'];
$password= $_POST['oldpass'];
$newpass= $_POST['newpass'];
$confpass= $_POST['confpass'];
$token = $_COOKIE['token'];



if($newpass == $confpass && !empty($newpass) && !empty($confpass) && $email == ''){
			//$date = new DateTime();
	$date_str = strval(mt_rand());

	$hash = crypt($newpass, $date_str);

	$sql = "UPDATE $_COOKIE[account_type] SET pass = '$hash', reg_time = '$date_str' WHERE $_COOKIE[account_type].token = '$token'";
	if(mysql_query($sql)){
	echo "suc";
}

} else if($newpass == $confpass && !empty($newpass) && !empty($confpass)  && !empty($email)){
			//$date = new DateTime();
	$date_str = strval(mt_rand());

	$hash = crypt($newpass, $date_str);

	mysql_select_db('users');
	$sql = "UPDATE $_COOKIE[account_type] SET pass = '$hash', reg_time = '$date_str' WHERE $_COOKIE[account_type].token = '$token'";
///

	if(mysql_query($sql)){
		mysql_select_db('users');

				$sql = "UPDATE $_COOKIE[account_type] SET email = '$email' WHERE $_COOKIE[account_type].token = '$token'";
				if(mysql_query($sql)){
						setcookie("name", "$email", time()+(86400*365));
						echo 'wowza';
				}
				
			}

	 

 }else if($newpass == '' && $confpass == '' && !empty($email)){
	

$name1 = mysql_real_escape_string($_COOKIE["name"]);
      $name1 = str_replace("@","At",$name1);
      $name1 = str_replace(".","Dot",$name1);
      	$name2 = mysql_real_escape_string($email);
      $name2 = str_replace("@","At",$name2);
      $name2 = str_replace(".","Dot",$name2);

if($_COOKIE[account_type] == 'organization'){

	mysql_select_db('orders');
	$sql3 = "RENAME TABLE `$name1` TO `$name2`";
	mysql_query($sql3);


}else{
	mysql_select_db('shoppers');
	$sql3 = "RENAME TABLE `$name1` TO `$name2`";
	mysql_query($sql3);

	$result = mysql_list_tables('orders');
	$num_rows = mysql_num_rows($result);
	for ($i = 0; $i < $num_rows; $i++) {
			$table = mysql_tablename($result, $i);
			$sql1 = "UPDATE $table SET customeremail = '$email' WHERE customeremail = '$_COOKIE[name]'";
			mysql_query($sql1) or die(mysql_error());
		}


}


		
	
	$result = mysql_list_tables('messages');
	$num_rows = mysql_num_rows($result);
	for ($i = 0; $i < $num_rows; $i++) {
			$table = mysql_tablename($result, $i);
			$sql1 = "UPDATE $table SET sender = '$email' WHERE sender = '$_COOKIE[name]'";
			$sql2 = "UPDATE $table SET receiver = '$email' WHERE receiver = '$_COOKIE[name]'";
			mysql_query($sql1) or die(mysql_error());
			mysql_query($sql2) or die(mysql_error());
		}
		$sql3 = "RENAME TABLE `$name1` TO `$name2`";
		mysql_query($sql3);

		setcookie("name", "$email", time()+(86400*365));


		mysql_select_db('users');
	$sql = "UPDATE $_COOKIE[account_type] SET email = '$email' WHERE $_COOKIE[account_type].token = '$token'";
	setcookie("name", "$email", time()+(86400*365));
	if(mysql_query($sql)){
		mysql_query($sql3);

		if(isset($email)){
			echo 'emale';
		}
	}

} else if($newpass != $confpass){
	echo 'notmatch';
}
?>