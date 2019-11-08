
<html>
	<html>
	<head>
		<meta charset = "UTF-8">
		<title>Messages</title>
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


</style>
	</head>

	<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif')">
	
		<div class="navbar">
		<a style="font-size: 16px" href="index.php"><strong>T.E.D</strong></a>
		<?php if($_COOKIE[account_type] == "organization"){

      		echo "<a href='orders.php'>Pending Orders</a>
			<a href='archivedproducts.php'>Archived Products</a>";
      	}
      	?>
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
						if($row['token'] != $_COOKIE['token']){ // log out invalid user
							setcookie("name", "", time() - 3600);
							setcookie("token", "", time() - 3600);
							setcookie("account_type", "", time() - 3600);
							header("Location: /notloggedin.html"); // Redirect browser to not logged in page 
							exit();
						} else {
							echo $row['name']; // Display User's name
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
				<?php
				if($_COOKIE[account_type] == "student"){
					echo "<div class='dropdown-content'>";
					echo "<a href='viewCart.php'>Cart</a>";
					echo "<a href='messages.php'>Inbox</a>";
					echo "<a href='usersettings.php'>Settings</a>";
					echo "<a href='sign-out.php'>Log Out</a>";
					echo "</div>";
				}
				else if($_COOKIE[account_type] == "organization"){
					echo "<div class='dropdown-content'>";
					echo "<a href='messages.php'>Inbox</a>";
					echo "<a href='usersettings.php'>Settings</a>";
					echo "<a href='sign-out.php'>Log Out</a>";
					echo "</div>";
				}
				?>
			</div>
		</div>
		</div>

	<h1 style="font-family: verdana;">Message Center:</h1>
		<h2 style="font-family: verdana;">Send a message!</h2>
		<?php
		echo "<form style='font-family: verdana; font-size: 80%' class='ajax id='sendit' action='send_message.php' method='post'>";

				
				if($_COOKIE[account_type] == "organization"){ 
					echo "Email:<br>";
			echo"<input type='text' id='buyer' name='receiver'><br>";
				}else{
					echo "Organization:<br>";
				echo "<select id='sendit' name='receiver'>";
               $query1 = "SELECT * FROM users.organization";
		$result5 = mysql_query($query1) or die(mysql_error());


               while($row = mysql_fetch_array($result5)){

               echo "<option value = ".$row['email'].">".$row['name']."</option>";
               }
             echo "</select><br>";
				}

				
				echo "Subject:<br>";
				echo "<input type='text' id='subject' name='subject'><br>";
				echo "Message:<br>";
				echo "<textarea id='textarea1' name='message' cols='40' rows='5'></textarea><br>";
				echo "<br><input type='submit' value='Send' id='send'>";
		echo "</form>"
		?>
<script type="text/javascript">

function get(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}

    document.getElementById('subject').value = get('subject').replace(new RegExp("\\+","g"),' ');
    document.getElementById('buyer').value = get('customeremail');


</script>
		
	
		<?php	
			date_default_timezone_set('America/New_York');
			define('DB_HOST', 'localhost');
			define('DB_NAME', 'myDB');
			define('DB_USER','root');
			define('DB_PASSWORD','mysql');

			$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
			
			if(!mysql_select_db('messages', $con)){
				$sql = 'CREATE DATABASE messages';
				mysql_query($sql, $con);
			}
			$db = mysql_select_db('messages', $con);
			$name = mysql_real_escape_string($_COOKIE["name"]);
			$name = str_replace("@","At",$name);
			$name = str_replace(".","Dot",$name);
			$query = sprintf("CREATE TABLE %s(
				message_num INT(255) AUTO_INCREMENT NOT NULL PRIMARY KEY,
				sender VARCHAR(100) NOT NULL,
				receiver VARCHAR(100) NOT NULL,
				subject VARCHAR(100),
				sorr VARCHAR(100) NOT NULL,
				body TEXT,
				time INT NOT NULL)",$name);
			
			
			mysql_query($query, $con);
			
			// if(mysql_query($query, $con)){
			// 	echo "Table created.";
			// 	$query = "SELECT * FROM ".$name." ORDER BY message_num";
			// 	$result = mysql_query($query, $con) or die('Select rows from table '.$name.': '.mysql_error());
			// 	$i = 0;
			// 	echo "<table>";
			// 	echo "<tr><th>Sender</th><th>Subject</th><th>Message</th><th>Time Recieved</th></tr>";
			// 	$message_lines = array();
			// 	while ((($row = mysql_fetch_array($result)))){
					
			// 		array_push($message_lines,'<tr><td>'.$row['sender'].'</td><td>'.$row['subject'].'</td><td>'.$row['body'].'</td><td>'.date('m - d - Y h:i:s A', $row['time']).'</td>');
			// 		$i++;
			// 	//	echo '<tr><td>'.$row['sender'].'</td><td>'.$row['subject'].'</td><td>'.$row['body'].'</td><td>'.date('m - d - Y h:i:s A', $row['time']).'</td>';
			// 	}
			// 	echo "</table>";
			// 	while($out = array_pop($message_lines) && $i<10){
			// 		$i++;
			// 		echo $out;
			// 	}
			// } else {
			// 	echo "Failed to connect to MySQL: " . mysql_error();
			// }
$result = mysql_list_tables('messages');
$num_rows = mysql_num_rows($result);


$table = mysql_tablename($result, $i);

$thingamadoo = mysql_real_escape_string($_COOKIE["name"]);
$thingamadoo = str_replace("@","At", $thingamadoo);
$thingamadoo = str_replace(".","Dot", $thingamadoo);

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
mysql_select_db('messages', $con);
$query = "SELECT * FROM $thingamadoo";






$resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
$rempty = 0;
while ($row = mysql_fetch_array($resultq)){
if($row['sorr']=='receive'){
$rempty = 1;
}
}

	if($rempty){

		echo "<h2 style='font-family: verdana;'>Received:</h2>";

		$resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
		echo "<table>";
	echo "<tr><th>From</th><th>Subject</th><th>Message</th><th>Time Recieved</th><th>Remove</th></tr>";
}else{

 echo "<h2 style='font-family: verdana;'> You've Received no Messages!</h2>";

}
	


while ($row = mysql_fetch_array($resultq)){
	if($row['sorr']=='receive'){
   echo "<tr>";
    echo "<td>".($row['sender'])."</td>";
    echo "<td>".($row['subject'])."</td>";
    echo "<td>".($row['body'])."</td>";
    echo "<td>".(date('m - d - Y h:i:s A', $row['time']))."</td>";
    echo "<td>";
    echo "<form class='ajax' action='delete_message.php' method='post'>";
    echo "<input name='sender' type='hidden' value=\"".$row['sender']."\">";
    echo "<input name='receiver' type='hidden' value=\"".$row['receiver']."\">";
    echo "<input name='subject' type='hidden' value=\"".$row['subject']."\">";
    echo "<input name='body' type='hidden' value=\"".$row['body']."\">";
    echo "<input name='sorr' type='hidden' value=\"".$row['sorr']."\">";
    echo "<input name='time' type='hidden' value=\"".$row['time']."\">";
    echo "<input type='submit' style='float:left' value='Remove' id='submit'>";
    echo "</form>";

    echo"</td>";
    echo "</tr>";
} 
}
echo "</table>";

$resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
$rempty = 0;
while ($row = mysql_fetch_array($resultq)){
if($row['sorr']=='sent'){
$rempty = 1;
}
}

	if($rempty){
		$resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
		echo "<table>";

	echo "<tr><th>To</th><th>Subject</th><th>Message</th><th>Time Received</th><th>Remove</th></tr>";
	echo "<h2 style='font-family: verdana;'>Sent:</h2>";
}else{
 echo "<h2 style='font-family: verdana;'> You've Sent no Messages!</h2>";

}
	

while ($row = mysql_fetch_array($resultq)){
	if($row['sorr']=='sent'){
    echo "<tr>";
    echo "<td>".($row['receiver'])."</td>";
    echo "<td>".($row['subject'])."</td>";
    echo "<td>".($row['body'])."</td>";
    echo "<td>".(date('m - d - Y h:i:s A', $row['time']))."</td>";
    echo "<td>";
    echo "<form class='ajax' action='delete_message.php' method='post'>";
    echo "<input name='sender' type='hidden' value=\"".$row['sender']."\">";
    echo "<input name='receiver' type='hidden' value=\"".$row['receiver']."\">";
    echo "<input name='subject' type='hidden' value=\"".$row['subject']."\">";
    echo "<input name='body' type='hidden' value=\"".$row['body']."\">";
    echo "<input name='sorr' type='hidden' value=\"".$row['sorr']."\">";
    echo "<input name='time' type='hidden' value=\"".$row['time']."\">";
    echo "<input type='submit' style='float:left' value='Remove' id='submit'>";
    echo "</form>";

    echo"</td>";
    echo "</tr>";
} 
}
echo "</table>";

 ?>	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
    $('form.ajax').on('submit', function(){
      var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};


      that.find('input[type!="submit"],#type_selector,select,textarea').each(function(index, value){
        var that = $(this),
        name = that.attr('name'),
        id = that.attr('id'),
        value = that.val();
        console.log(name);
       if(id =='sendit' ){
		data[name] = $('#sendit option:selected').val();
		console.log("fuck");
		console.log(data[name]);
		console.log("fuck");
       }else if(id == 'textarea1'){
		data[name] = $('#textarea1').val();
       }else{
        data[name] = value;}
      }
      
      // that.find('#type_selector').each(function(index, value){
        // var that = $(this),
        // name = that.attr('name'),
        // value = that.val();
        // console.log(this);
        // data[name] = value;
      // }
      );

      console.log(data);

      $.ajax({
        url: url,
        type: type,
        data: data,
        success: function(response){
            $("body").html(response);
        }
      });

      return false;
    });
    </script>

	</body>
</html>
