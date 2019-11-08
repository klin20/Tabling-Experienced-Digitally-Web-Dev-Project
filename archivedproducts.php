<!DOCTYPE html>
<html>
<head>
	<meta charset = "UTF-8">
	<title> 
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


	
	Archived Products</title>
	<link rel="stylesheet" type="text/css" href="navbar.css">
</head>
<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif');">

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

						echo "Hello, ", $row['name'], "!"; // Display User's name

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

	<h1 style="font-family: verdana;">Archived Products:</h1>



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
		$query = "SELECT * FROM $organization WHERE CURDATE() >= expires";

		$resultq = mysql_query($query); //or die("<br/>Your organization has not created any products yet!");
		if($resultq){
		
			echo "<table>";
			while ($row = mysql_fetch_array($resultq)) {
				echo "<tr><td>";
				echo "<form class='ajax' action='renewproduct.php' method='post'>";
				echo "<input name='product' type='hidden' value=\"".$row['product']."\">";
				echo"<input name='expires' type='date' >";
				echo "<input type='submit' style='float:left' value='Renew' id='submit'>";
				echo "</form>";
				echo "</td>";
				echo "<td>";

				//echo "<h3>"."Product: ".($row['product'])."</h3>"."<h5> Features: ".($row['feature1']).", ".($row['feature2']).", ".($row['feature3']).", ".($row['feature4'])."<br>"."Price: ".($row['price'])."</h5>";
				
				$productString = "<h3>"."Product: ".($row['product'])."</h3><h5> ";
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
			echo "<br/>Your organization does not have any expired products!";
		}
	?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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