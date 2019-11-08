
<?php
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'myDB');
	define('DB_USER','root');
	define('DB_PASSWORD','mysql');

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

	// Make users the current database
	$db = mysql_select_db('shoppers', $con);

	if (!$db) {
	  // If we couldn't, then it either doesn't exist, or we can't see it.
		$sql = 'CREATE DATABASE shoppers';
		
		if (mysql_query($sql, $con)) {
		//	echo "Database organizations created successfully\n";
			$db = mysql_select_db('shoppers', $con);
		} else {
			echo 'Error creating database: ' . mysql_error() . "\n";
		}
	}

	/* $organization = $_COOKIE["name"];


	$query1 = sprintf("SELECT * FROM users.student WHERE email LIKE '%s'", mysql_real_escape_string($organization));
	$result5 = mysql_query($query1) or die(mysql_error());
	$row = mysql_fetch_array($result5); */
	//$organization54 = $row['name'];
	//$organization = str_replace(' ', '', $organization54);

	$name = mysql_real_escape_string($_COOKIE["name"]);
	$name = str_replace("@","At",$name);
	$name = str_replace(".","Dot",$name);

	$query = sprintf("SELECT %s FROM shoppers.tables",mysql_real_escape_string($name));
	$resultq = mysql_query($query, $con);
	$query = sprintf("CREATE TABLE %s(
	product VARCHAR(255) NOT NULL,
	product_id INT(255) AUTO_INCREMENT NOT NULL PRIMARY KEY,
	organization VARCHAR(100) NOT NULL,
	time INT NOT NULL,
	feature1 VARCHAR(100),
	feature2 VARCHAR(100),
	feature3 VARCHAR(100),
	feature4 VARCHAR(100),
	feature5 VARCHAR(100),
	feature6 VARCHAR(100),
	feature7 VARCHAR(100),
	feature8 VARCHAR(100),
	feature9 VARCHAR(100),
	quantity INT(255) NOT NULL,
	price FLOAT(255, 2) NOT NULL)", mysql_real_escape_string($name));

	mysql_query($query, $con);// or die( mysql_error());

	$product = mysql_real_escape_string($_POST['product']);
	$organization = mysql_real_escape_string($_POST[organization]);
	$quantity = mysql_real_escape_string($_POST[quantity]);
	$price = mysql_real_escape_string($_POST[price]);
	$time = time();
	$numFeatures = mysql_real_escape_string($_POST[featureCount]);
	
	$insertStr1 = "INSERT INTO $name (product, organization, time, quantity, price";
	$insertStr2 = ") VALUES ('$product', '$organization', '$time', '$quantity', '$price'";
	$insertStr3 = ")";
	
	for($i = 1; $i < $numFeatures + 1; $i++ ){
		$insertStr1 = $insertStr1 . ", feature" . strval($i);
		if($_POST['choiceType'.strval($i)] == "radio"){
			$insertStr2 = $insertStr2 . ", '".$_POST['optionName' . strval($i)].' : '.$_POST["choice" . strval($i)]."'";
		} else {
			$choicesTemp = "";
			for($j = 1; $j < $_POST['choiceCount'.strval($i)] + 1; $j++){
				if($_POST['choice' . strval($i)."_".strval($j)] != null){
					if($choicesTemp != ""){
						$choicesTemp = $choicesTemp . ", ";
					}
					$choicesTemp = $choicesTemp . $_POST['choice' . strval($i)."_".strval($j)];
				}
			}
			$insertStr2 = $insertStr2 . ", '".$_POST['optionName' . strval($i)].' : ' . $choicesTemp."'";
		}
		
	}
	mysql_query($insertStr1.$insertStr2.$insertStr3) or die($insertStr1.$insertStr2.$insertStr3.":".mysql_error());
	
	echo "'$product' successfully added to your cart!";
	

	?>
