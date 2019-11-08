<!DOCTYPE html>
<html>
<head>
	<meta charset = "UTF-8">
	<title>Welcome 
	<?php
		if(isset($_COOKIE["name"]) && isset($_COOKIE["token"])) { //change to checking db
			define('DB_HOST', 'localhost');
			define('DB_NAME', 'myDB');
			define('DB_USER','root');
			define('DB_PASSWORD','mysql');

			$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
			
			if(!mysql_select_db('users', $con)){
				echo "Error: Could not connect to db.";
				exit();
			}else{
				$db = mysql_select_db('users', $con);
			}
			$queryStr = sprintf("SELECT * FROM %s where email = '%s'",mysql_real_escape_string($_COOKIE[account_type]),mysql_real_escape_string($_COOKIE[name]));
			$query = mysql_query($queryStr) or die(mysql_error());
			$row = mysql_fetch_array($query);
			if($row['token'] != $_COOKIE['token'] or $_COOKIE[account_type] != "organization"){
				setcookie("name", "", time() - 3600);
				setcookie("token", "", time() - 3600);
				setcookie("account_type", "", time() - 3600);
				header("Location: /notloggedin.html"); // Redirect browser to not logged in page 
				exit();
			} else {
				$org_name = $row['name'];
				echo $org_name;
			}
		} else {
			setcookie("name", "", time() - 3600);
			setcookie("token", "", time() - 3600);
			setcookie("account_type", "", time() - 3600);
			header("Location: /notloggedin.html"); // Redirect browser to not logged in page 
			exit();
		}
	?>

<?php

define('DB_HOST', 'localhost');
	define('DB_NAME', 'myDB');
	define('DB_USER','root');
	define('DB_PASSWORD','mysql');

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

	// Make users the current database
	$db = mysql_select_db('orders', $con);

	if (!$db) {
	  // If we couldn't, then it either doesn't exist, or we can't see it.
		$sql = 'CREATE DATABASE orders';
		
		if (mysql_query($sql, $con)) {
		//	echo "Database organizations created successfully\n";
			$db = mysql_select_db('orders', $con);
		} else {
			echo 'Error creating database: ' . mysql_error() . "\n";
		}
	}
$name = mysql_real_escape_string($_COOKIE["name"]);
      $name = str_replace("@","At",$name);
      $name = str_replace(".","Dot",$name);

$query = sprintf("SELECT %s FROM orders.tables",mysql_real_escape_string($name));
  $resultq = mysql_query($query, $con);
  $query = sprintf("CREATE TABLE %s(
  PRIMARY KEY(product, feature1, feature2, feature3, feature4, quantity, price),
  ordernumber INT(255) NOT NULL,
  product VARCHAR(255) NOT NULL,
  customername VARCHAR(255) NOT NULL,
  customeremail VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  feature1 VARCHAR(40) NOT NULL,
  feature2 VARCHAR(40) NOT NULL,
  feature3 VARCHAR(40) NOT NULL,
  feature4 VARCHAR(40) NOT NULL,
  quantity INT(255) NOT NULL,
  price FLOAT(255, 2) NOT NULL)", mysql_real_escape_string($name));

  mysql_query($query, $con);


	?>
	
	</title>
	<link rel="stylesheet" type="text/css" href="navbar.css">
</head>
<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif')">
	<div class="navbar">
		<a style="font-size: 16px" href="index.php"><strong>T.E.D</strong></a>

		<a href="orders.php">Pending Orders</a>
		<a href="archivedproducts.php">Archived Products</a>
		<div class="navbar">
			<div style="float:right" class="dropdown">
				<button class="dropbtn">
							<?php
				if(isset($_COOKIE["name"]) && isset($_COOKIE["token"])) {
					define('DB_HOST', 'localhost');
					define('DB_NAME', 'myDB');
					define('DB_USER','root');
					define('DB_PASSWORD','mysql');

					$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
					
					if(!mysql_select_db('users', $con)){
						echo "Error: Could not connect to db.";
						exit();
					}else{
						$db = mysql_select_db('users', $con); // connect to users database
					}
					$queryStr = sprintf("SELECT * FROM %s where email = '%s'", // select row corresponding to user
					mysql_real_escape_string($_COOKIE[account_type]),
					mysql_real_escape_string($_COOKIE[name]));
					$query = mysql_query($queryStr) or die(mysql_error());    
					$row = mysql_fetch_array($query);
					if($row['token'] != $_COOKIE['token'] or $_COOKIE[account_type] != "organization"){ // log out invalid user
						setcookie("name", "", time() - 3600);
						setcookie("token", "", time() - 3600);
						setcookie("account_type", "", time() - 3600);
						header("Location: /notloggedin.html"); // Redirect browser to not logged in page 
						exit();
					} else {
						echo "Welcome ", $row['name'], "!"; // Display User's name
					}
				} else {
					setcookie("name", "", time() - 3600);
					setcookie("token", "", time() - 3600);
					setcookie("account_type", "", time() - 3600);
					header("Location: /notloggedin.html"); // Redirect browser to not logged in page 
					exit();
				}
			?> 
				<i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
					<a href="messages.php">Inbox</a>
					<a href="usersettings.php">Settings</a>
					<a href="sign-out.php">Log Out</a>
				</div>
			</div>
		</div>
	</div>


	<h1 style="font-family: verdana;">What's For Sale?:</h1>
	<fieldset style="width:60%; background-color: #fafafa; font-family: verdana; font-size: 85%; opacity: 0.85">

		<form class="ajax" action="addproduct.php" method="post" enctype="multipart/form-data"> <!-- Maybe remove enctype -->
			Product Name:<br>
			<input type="text" name="product"><br>
			Type:<br>
			<select name="type" id="type_selector">
				<option value="food">Food</option>
				<option value="drink">Beverages</option>
				<option value="clothes">Clothing</option>
				<option value="trinkets">Trinkets</option>
				<option value="event">Tickets and Events</option>
				<option value="other">Other</option>
			</select><br>
			Price:<br>
			$<input type="number" name="price" step="0.01"><br>
			Offer Expiration Date (Optional):<br>
			<input type="date" name="expires"><br>
			Description (Optional):<br>
			<input type="text" name="description"><br>
			
			<input type="button" value="Add an Option" class="addOption" id="1" >
			<input type="button" value="Delete Last Option" class="delOption" disabled=true >
			<br>
			<div id="option1"></div>
			<input type="submit" value="Submit" id="submit" name="submit">
		</form>
	</fieldset>
	<h2 id="dupe"> </h2>
	<h1 style="font-family: verdana"> Products Your Organization is Selling: </h1>
	
	<?php
		define('DB_HOST', 'localhost');
		define('DB_USER','root');
		define('DB_PASSWORD','mysql');

		$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

		$organization = $_COOKIE["name"];

		$query1 = "SELECT * FROM users.organization WHERE email LIKE '$organization'";
		$result5 = mysql_query($query1) or die(mysql_error());
		$row = mysql_fetch_array($result5);
		$organization54 = $row['name'];
		$organization = str_replace(' ', '', $organization54);

		$db = mysql_select_db('organizations');
		$query = "SELECT * FROM $organization WHERE CURDATE() < expires";

		$resultq = mysql_query($query); //or die("<br/>Your organization has not created any products yet!");
		if($resultq){
		
			echo "<table>";
			while ($row = mysql_fetch_array($resultq)) {
				echo "<tr><td>";
				echo "<form class='ajax' action='delete_product.php' method='post'>";
				echo "<input name='product' type='hidden' value=\"".$row['product']."\">";
				echo "<input type='submit' style='float:left' value='Remove' id='submit'>";
				echo "</form>";
				echo "</td>";
				echo "<td>";

				//echo "<h3>"."Product: ".($row['product'])."</h3>"."<h5> Features: ".($row['feature1']).", ".($row['feature2']).", ".($row['feature3']).", ".($row['feature4'])."<br>"."Price: ".($row['price'])."</h5>";
				

				$productString = "<h3 style='font-family: verdana'>"."Product: ".($row['product'])."</h3><h5 style='font-family: verdana'> ";

				$feat = 0;
				while($row['feature'.strval(++$feat)] != null){
					$opt = array();
					parse_str($row['feature'.strval($feat)], $opt);
					if($opt["option_type"] == "radio"){
						$type = "ONE";
					} else {
						$type = "ANY";
					}
					 
					$productString =$productString."Option: '".$opt["option_name"]."' with ".$type." of the following choices: ";
					for($i = 1;$i < count($opt) - 1; $i++){
						$productString =$productString.$opt["choice".strval($i)];
						if($i != count($opt) - 2){
							$productString =$productString.", ";
						}
					}
					$productString = $productString."<br>";
				}
				$productString = $productString."Price: ".($row['price'])."</h5>";
				echo $productString;
				
				
				echo "</td></tr>";
			}
			echo "</table>";
		} else {
			echo "<br/>Your organization has not created any products yet!";
		}
	?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/addOption.js"></script>
	<script src="/addChoice.js"></script>
    <script type="text/javascript">
		$('form.ajax').on('submit', function(){
			var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};


			that.find('input[type!="submit"],#type_selector').each(function(index, value){
				var that = $(this),
				name = that.attr('name'),
				value = that.val();
				console.log(this);
				data[name] = value;
			}

			);

			console.log(data);

			$.ajax({
				url: url,
				type: type,
				data: data,
				success: function(response){

					if(response.trim().localeCompare("DUPLICATE".trim()) == 0){
						document.getElementById("dupe").innerHTML = "You're already selling that product!";
					}else{
						$("body").html(response);
					}
				}
			});

			return false;
		});
    </script>

</body>
</html>