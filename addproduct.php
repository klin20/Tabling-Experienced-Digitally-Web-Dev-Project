	<?php	
	
	
		// Get all info from POST
	$product_name = mysql_real_escape_string($_POST["product"]);
	$product_type = mysql_real_escape_string($_POST["type"]);
	$price = (float) mysql_real_escape_string($_POST["price"]);
	$expiration = mysql_real_escape_string($_POST["expires"]);
	$description = mysql_real_escape_string($_POST["description"]);
	
	
	function OptionString($optionNumber){
		if($_POST["optionName".strval($optionNumber)] == null){
			return null;
		}
		$returnString = "option_name=".$_POST["optionName".strval($optionNumber)]."&option_type=".$_POST["selectionType".strval($optionNumber)];
		$choiceNumber = $_POST["numChoices".strval($optionNumber)];
		for($i = 1; $i < $choiceNumber+ 1; $i++){
			
			$returnString = $returnString . "&choice".strval($i)."=".$_POST["choiceFieldOption".strval($optionNumber)."_".strval($i)];
		}
		return mysql_real_escape_string($returnString);
	}

	
	$allOption = array();
	for($i = 1; $i < 10; $i++){
		array_push($allOption, OptionString($i));
	}

	
	
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'myDB');
	define('DB_USER','root');
	define('DB_PASSWORD','mysql');

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

	// Make users the current database
	$db = mysql_select_db('organizations', $con);

	if (!$db) {
	  // If we couldn't, then it either doesn't exist, or we can't see it.
		$sql = 'CREATE DATABASE organizations';
		
		if (mysql_query($sql, $con)) {
		//	echo "Database organizations created successfully\n";
			$db = mysql_select_db('organizations', $con);
		} else {
			echo 'Error creating database: ' . mysql_error() . "\n";
		}
	}

	$organization = $_COOKIE["name"];


	$query1 = sprintf("SELECT * FROM users.organization WHERE email LIKE '%s'", mysql_real_escape_string($organization));
	$result5 = mysql_query($query1) or die(mysql_error());
	$row = mysql_fetch_array($result5);
	$organization54 = $row['name'];
	$organization = str_replace(' ', '', $organization54);


	$query = sprintf("SELECT %s FROM organizations.tables",mysql_real_escape_string($organization));
	$resultq = mysql_query($query, $con);
	$query = sprintf("CREATE TABLE %s(

	product VARCHAR(255) NOT NULL PRIMARY KEY,
	type VARCHAR(40) NOT NULL,
	price FLOAT(255, 2) NOT NULL,
	expires DATE,
	description TEXT,
	feature1 VARCHAR(500) ,
	feature2 VARCHAR(500) ,
	feature3 VARCHAR(500) ,
	feature4 VARCHAR(500) ,
	feature5 VARCHAR(500) ,
	feature6 VARCHAR(500) ,
	feature7 VARCHAR(500) ,
	feature8 VARCHAR(500) ,
	feature9 VARCHAR(500) )", 
	mysql_real_escape_string($organization));
	mysql_query($query, $con);


	
	
	
	
	

//	function Addproduct($organizationj)
//	{

		$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

	// Make users the current database
	$db = mysql_select_db('organizations', $con);
			//$query = "SELECT $organization FROM organizations.tables";
	        //$studentTable = mysql_query($query);
		session_start(); 

			$sql2 = "INSERT INTO ".mysql_real_escape_string($organization)." (product, type, price";
			$sql2_2 = ") VALUES ('".$product_name."', '".$product_type."', '".$price."'";
			if($_POST["expires"] != null){
				$sql2 = $sql2 . ", expires";
				$sql2_2 = $sql2_2 . ", '".$expiration."'";
			} else {
				$sql2 = $sql2 . ", expires";
				$sql2_2 = $sql2_2 . ", '".date('Y-m-d',time()+100000000)."'";
			}
			if($_POST["description"] != null){
				$sql2 = $sql2 . ", description";
				$sql2_2 = $sql2_2 . ", '".$description."'";
			}
			$index = 1;
			while( $allOption[$index - 1] != null){
				$sql2 = $sql2 . ", feature" . strval($index);
				$sql2_2 = $sql2_2 . ", '".$allOption[$index - 1]."'";
				$index++;
			}
			$sql2 = $sql2 . $sql2_2 . ")";


			if(mysql_query($sql2, $con) == false){
				echo "DUPLICATE";
				//echo $sql2;
				exit();
			}else{
				//echo $sql2;
				header("Location: /organization_landing.php");
				exit();
			}
//	}

//	Addproduct($organization);

	?>
