<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'myDB');
define('DB_USER','root');
define('DB_PASSWORD','mysql');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

if(!mysql_select_db('users', $con)){
    echo "Wrong Email or Password";
}else{
    $db = mysql_select_db('users', $con);
//    $query = sprintf("SELECT %s FROM users.tables",mysql_real_escape_string($account_type));
//    $result = mysql_query($query, $con);

}
$account_type = $_POST['account_type'];

//if($_POST['account_type'] == 'Organization'){
//  $account_type = 'organization';
//}
function SignIn($account_type)
{
session_start();   //starting the session for user profile page
if(!empty($_POST['email']) and !empty($_POST['password']))   //checking the 'user' name which is from Sign-In.html, is it empty or have some text
{
	$queryStr = sprintf("SELECT *  FROM %s where email = '%s'", mysql_real_escape_string($account_type), mysql_real_escape_string($_POST[email]));
    $query = mysql_query($queryStr) or die(mysql_error());
    $row = mysql_fetch_array($query);
    if(empty($row['email']))
    {
        echo "Wrong Email or Password";
    }
    else
    {
        if(crypt($_POST['password'], $row['reg_time']) == $row['pass'] ){
            $query = sprintf("SELECT %s FROM users.tables",mysql_real_escape_string($account_type));
            $studentTable = mysql_query($query);
            $key = rand(0,100000);

            $sql = sprintf("UPDATE %s SET token=$key WHERE email='%s'",mysql_real_escape_string($account_type),mysql_real_escape_string($_POST[email]));
            mysql_query($sql);
            setcookie("name", $_POST['email'], time()+(86400*365));
            setcookie("token", $key, time()+(86400*365)); 
			setcookie("account_type", $account_type, time()+(86400*365)); 			
            echo $account_type."_landing.php"; // Redirect browser to registration confirmed page 
            exit();
            
        }else {
            echo "Wrong Password!";
        }
    }
}
else{
    echo "Must fill out all of form";
}

}

function set($name,$value = NULL) { 
    return setcookie($name, $value, (time()+86400) ); 
} 

SignIn($account_type);

?>
