<?php
  require_once('./config.php');

  $token  = $_POST['stripeToken'];

  $customer = \Stripe\Customer::create(array(
      'email' => $_COOKIE['name'],
      'source'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $_POST['price'],
      'currency' => 'usd'
  ));


  // Ryan's addition Start
  define('DB_HOST', 'localhost');
	define('DB_USER','root');
	define('DB_PASSWORD','mysql');


	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
	$shopper = $_COOKIE["name"];
	$shopper = str_replace("@","At",$shopper);
    $shopper = str_replace(".","Dot",$shopper);

	// Make shoppers the current database
	$db = mysql_select_db('shoppers', $con);
	session_start();

  $query = "SELECT * FROM $shopper";
  $resultq = mysql_query($query) or die(mysql_error());


  while($row = mysql_fetch_array($resultq)){



    mysql_select_db('users');

    $queryStr = sprintf("SELECT * FROM organization WHERE name LIKE '%s'", // select row corresponding to user
          mysql_real_escape_string($row['organization']));
         
          $query34 = mysql_fetch_array(mysql_query($queryStr));
          $table = $query34['email'];
      $table = str_replace("@","At",$table);
      $table = str_replace(".","Dot",$table);
      

    $queryaddress = sprintf("SELECT * FROM student WHERE email LIKE '%s'", // select row corresponding to user
          mysql_real_escape_string($_COOKIE['name']));
          $query44 = mysql_query($queryaddress) or die(mysql_error());  
          $query54 = mysql_fetch_array($query44);

    

          mysql_select_db('orders');
    $queryinsert = sprintf("INSERT INTO %s (ordernumber, product, customername, customeremail, address, feature1, feature2, feature3, feature4, quantity, price) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',".floatval($row['price']).")",
     
         mysql_real_escape_string($table),
         mysql_real_escape_string('1'),
        mysql_real_escape_string($row['product']),
        mysql_real_escape_string($query54['name']),
        mysql_real_escape_string($_COOKIE['name']),
        mysql_real_escape_string($query54['address']),
        mysql_real_escape_string($row['feature1']),
        mysql_real_escape_string($row['feature2']),
        mysql_real_escape_string($row['feature3']),
        mysql_real_escape_string($row['feature4']),
        mysql_real_escape_string($row['quantity'])
        );
  


  mysql_query($queryinsert);
  }
 
  mysql_select_db('shoppers');
	$query1 = "DELETE FROM $shopper ";

	$result5 = mysql_query($query1);

// Ryan's addition END

//$_SESSION['price'] = $_POST['price'];
setcookie('price', $_POST['price']);
header('Location: viewCart.php');
?>