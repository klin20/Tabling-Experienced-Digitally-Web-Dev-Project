<!DOCTYPE html>
<html>
<head>
	<meta charset = "UTF-8">
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="navbar.css">
<style>
table {
    font-family: verdana;
    font-size: 12px;
    border-collapse: collapse;
    width: 40%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr {
    background-color: #fafafa;
    opacity: 0.90;
}

h1, h2{
	font-family: verdana;
}

</style>
</head>
<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif');">
	<div class="navbar">
		<a style="font-size: 16px" href="index.php"><strong>T.E.D</strong></a>
<!-- 		<a href="viewCart.php">View Cart</a> -->
		
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
					if($row['token'] != $_COOKIE['token'] or $_COOKIE[account_type] != "student"){ // log out invalid user
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
				<a href="viewCart.php">Cart</a>
				<a href="messages.php">Inbox</a>
				<a href="usersettings.php">Settings</a>
				<a href="sign-out.php">Log Out</a>
			</div>
		</div>
	</div>
	</div>
	<h1> What's For Sale? </h1>
	<h3 id="blurb"> </h3>

	<?php
		define('DB_HOST', 'localhost');
		define('DB_USER','root');
		define('DB_PASSWORD','mysql');

		$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

		$result = mysql_list_tables('organizations');

		$sales = false; // boolean to show if nothing is for sale

		if($result){ // only try to display products if organizations exist
			
			echo 'Product type filter: <select id="type_selector" name="type_selector">
				<option style="font-family: verdana;" value="food">Food</option>
				<option style="font-family: verdana;" value="drink">Beverages</option>
				<option style="font-family: verdana;" value="clothes">Clothing</option>
				<option style="font-family: verdana;" value="trinkets">Trinkets</option>
				<option style="font-family: verdana;" value="event">Tickets and Events</option>
				<option style="font-family: verdana;" value="other">Other</option>
				<option style="font-family: verdana;" value="all" selected>All</option>
			</select>';
			
			$num_rows = mysql_num_rows($result);
			for ($i = 0; $i < $num_rows; $i++) {
				
				$table = mysql_tablename($result, $i);
				$query = "SELECT * FROM $table WHERE CURDATE() < expires";
				$resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
				
				if(mysql_num_rows($resultq) > 0){ // only display organizations currently selling products
					$sales = false;
					
					$header = "<h1>"."Organization: ".$table."</h1>";
					$generatedHtml = "";
					
					while ($row = mysql_fetch_array($resultq)){
						$sales = true;
						$product_name = $row["product"];
						$product_type = $row["type"];
						$product_price = $row["price"];
						$description = $row["description"];
						
						if($description == null){
							$description = "No description available.";
						}
						
						$features = array();
						$featureNum = 1;
						$feature = $row["feature1"];	
						while($feature != null){
							array_push($features, $feature);
							$feature = $row["feature".strval(++$featureNum)];
						}
						
						$productHtml = 
							"<div class=\"".$product_type."\"><table><form class=\"ajax\" action=\"addcart.php\" method=\"post\">
							<input name=\"product\" id = \"product\" type=\"hidden\" value=\"".$product_name."\">
							<input name=\"organization\" id = \"organization\" type=\"hidden\" value=\"".$table."\">
							<input name=\"featureCount\" id = \"featureCount\" type=\"hidden\" value=\"".strval(count($features))."\">
							<input name=\"price\" id = \"price\" type=\"hidden\" value=\"".$product_price."\"><tr class=\"".$product_type."\">
							<input name=\"price\" id = \"price\" type=\"hidden\" value=\"".$product_price."\"><tr class=\"".$product_type."\">
							<th><p>".$product_name."</p><p>$".$product_price."</p></th>
							<th><p>".$description."</p></th>".featureDisplay($features)."
							<th ><p>Quantity: <input type=\"number\" name=\"quantity\" value=\"1\" min=\"1\"></p><br>
							<input type=\"submit\" value=\"Add To Cart\" id=\"submit\"></th></tr></form></table></div>
							";
						$generatedHtml = $generatedHtml . $productHtml;
						
					}
					if($sales){
						echo $header.$generatedHtml;
					}
				}
			}
			if(!$sales){
				echo "<p>Sorry, there is currently nothing for sale.</p>";
			}
		}
		else {
			echo "<p>Sorry, there are no organizations registered yet!</p>";
		}

	function featureDisplay($feature_array){
		$returnString = "<div class=\"features\">";
		for($index = 0; $index < count($feature_array); $index++){
			$feature = $feature_array[$index];
			$opt = array();
			parse_str($feature, $opt);
			
			$returnString = $returnString."
				<th><p id=\"option".strval($index+1)."\"> ".$opt[option_name]." </p>
				<input name=\"optionName".strval($index+1)."\" id = \"optionName\" type=\"hidden\" value=\"".$opt[option_name]."\">
				<input name=\"choiceType".strval($index+1)."\" id = \"choiceType\" type=\"hidden\" value=\"".$opt[option_type]."\">
				<input name=\"choiceCount".strval($index+1)."\" id = \"choiceCount\" type=\"hidden\" value=\"".strval(count($opt) - 2)."\">
				<div class=\"choices\">";
			for($i = 1;$i < count($opt) - 1; $i++){
				$name = "choice".strval($index+1);
				if($opt[option_type] == "checkbox"){
					$name = $name."_".strval($i);
				} else if($i == 1){
					$name = $name."\" checked=\"checked";
				}
				$returnString = $returnString . "<input type=\"".$opt[option_type]."\" name=\"".$name."\" value=\"".$opt['choice'.strval($i)]."\"> ".$opt['choice'.strval($i)]."<br>";
			}	
			$returnString = $returnString . "</th></div>";
			
		}
		return $returnString. "</div>";
	}	
		
		
	?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
		$('form.ajax').on('submit', function(){
			var that = $(this),
			urlq = that.attr('action'),
            typeq = that.attr('method'),
            dataq = {};
			
			dataq = that.serialize();
/*
			that.find('input[type!="submit"]').each(function(index, value){
				var that = $(this),
				name = that.attr('name'),
				value = that.val();
				id = that.attr('id');
				
				var eleType = that.attr('type');
				//Ryan's additions
				console.log(this);
				//data[name] = value;
				//End Ryan
			
				 if(eleType == 'checkbox' ||eleType == 'radio'){
					if(that.prop("checked") == true){
						data[name] = value;    
					}
				} else {
					data[name] = value;
				} 
			});
*/
			console.log(dataq);

			$.ajax({
				url: urlq,
				type: typeq,
				data: dataq,
				success: function(response){
					
					document.getElementById("blurb").innerHTML = response;
					
				}
			});

			return false;
		});
    </script>
	<script type="text/javascript">
		
		$(document).ready(function(){

			if($("#type_selector").val() != "all"){
				$(".food").hide();
				$(".drink").hide();
				$(".clothes").hide();
				$(".trinkets").hide();
				$(".event").hide();
				$(".other").hide();
				$("."+$("#type_selector").val()).show();
			} else {
				$(".food").show();
				$(".drink").show();
				$(".clothes").show();
				$(".trinkets").show();
				$(".event").show();
				$(".other").show();
			}
			
			$("[value='']").hide();
			
		});
	
		$("#type_selector").change(function(){
			if($("#type_selector").val() != "all"){
				$(".food").hide();
				$(".drink").hide();
				$(".clothes").hide();
				$(".trinkets").hide();
				$(".event").hide();
				$(".other").hide();
				$("."+$("#type_selector").val()).show();
			} else {
				$(".food").show();
				$(".drink").show();
				$(".clothes").show();
				$(".trinkets").show();
				$(".event").show();
				$(".other").show();
			}
			
		});
	</script>
</body>
</html>