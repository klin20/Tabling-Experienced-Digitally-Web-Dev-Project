<!DOCTYPE html>
<html>
<head>
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
  <meta charset = "UTF-8">
  <title>Welcome Buyer</title>
  <link rel="stylesheet" type="text/css" href="navbar.css">
</head>
<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif')">
  <div class="navbar">

    <a style="font-size: 16px" href="index.php"><strong>T.E.D</strong></a>

    <a href="orders.php">Pending Orders</a>
<a href="archivedproducts.php">Archived Products</a>
    <div class="navbar">
      <div style="float:right" class="dropdown">
        <button class="dropbtn"><?php if(isset($_COOKIE["name"]) && isset($_COOKIE["token"])) {
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

<h2 id="dupe"> </h2>

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
    //  echo "Database organizations created successfully\n";
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
  PRIMARY KEY(ordernumber, product, customer, address, feature1, feature2, feature3, feature4, quantity, price),
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


<?php
    define('DB_HOST', 'localhost');
    define('DB_USER','root');
    define('DB_PASSWORD','mysql');

    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

        $name = mysql_real_escape_string($_COOKIE["name"]);
      $name = str_replace("@","At",$name);
      $name = str_replace(".","Dot",$name);
        mysql_select_db('orders');
        $query = "SELECT * FROM ".$name." ORDER BY address";
        $resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
        
        if(mysql_num_rows($resultq) > 0){ // only display organizations currently selling products
          $sales = true;
          echo "<h1>"."Pending Orders: ".$table."</h1>";
          
          $ADDRESS;
          $CUSTOMERNAME;
          $CUSTOMEREMAIL;
          while ($row = mysql_fetch_array($resultq)){
            if(!$ADDRESS || $ADDRESS != $row['address']){
             if($ADDRESS && $ADDRESS != $row['address']){
            
              echo "<tr><th colspan='3'>
            
            <form action='messages.php' method='post'>";
            echo "<label style='float:left' for='submit'>Send ".$CUSTOMERNAME." a Message</label>";
            echo "<input name='customeremail' type='hidden' value=\"".$CUSTOMEREMAIL."\">";
            echo "<input type='hidden' name='subject' value='Your Recent Order'>";
            echo "<input type='submit' style='float:right' value='Message' id='submit'> </form>
            </tr></th>";
            echo "</table>"; 
        
             }
             $ADDRESS  = $row['address'];
            $CUSTOMERNAME = $row['customername'];
            $CUSTOMEREMAIL = $row['customeremail'];
             echo "<h2 style='margin-bottom:0px;'>Customer: ".$row['customername']."<br> Email: ".$row['customeremail']."<br> Address: ".$row['address']."</h2>";
             echo "<table>";
             echo "<tr><th>Product</th><th>Options</th><th>Finished?</th></tr>";
            }

            echo "<tr class=\"".$row['type']."\">";
            echo "<td><h3>".($row['product'])."</h3></td>";
            echo "<td>";
            echo "<form action='delete_order.php' method='post'>";
            
       
            echo "<input name='customername' type='hidden' value=\"".$row['customername']."\">";
            echo "<input name='customeremail' type='hidden' value=\"".$row['customeremail']."\">";
            echo "<input name='address'  type='hidden' value=\"".$row['address']."\">";


            echo "<input name='product' id = 'product' type='hidden' value=\"".$row['product']."\">";
        
            echo "<input type='hidden' name='feature1'  value=\"".$row['feature1']."\"<br>";
            echo "<label for='feature1'>".$row['feature1']."</label><br>";
            
            echo "<input type='hidden' name='feature2'  value=\"".$row['feature2']."\"<br>";
            echo "<label for='feature2'>".$row['feature2']."</label><br>";
            
            echo "<input type='hidden' name='feature3'  value=\"".$row['feature3']."\"<br>";
            echo "<label for='feature3'>".$row['feature3']."</label><br>";
            
            echo "<input type='hidden' name='feature4' value=\"".$row['feature4']."\"<br>";
            echo "<label for='feature4'>".$row['feature4']."</label>";
            echo "<input type='hidden' name='price' value=\"".$row['price']."\"<br>";
            
            echo "<br><label id='quantity' for='quantity'>Quantity:". $row['quantity']."</label><br>";
            echo "<input type='hidden' name='quantity' value=\"".$row['quantity']."\"";
            
            echo "</td><td><input type='submit' style='float:center' value='Resolve' id='submit'> </td></form>";
            echo "</tr>";

          
            
            
          }
          
           echo "<tr><th colspan='3'>
            
            <form action='messages.php' method='get'>";
            echo "<label style='float:left' for='submit'>Send ".$CUSTOMERNAME." a Message</label>";
            echo "<input name='customeremail' type='hidden' value=\"".$CUSTOMEREMAIL."\">";
            echo "<input type='hidden' name='subject' value='Your Recent Order'>";
            echo "<input type='submit' style='float:right' value='Message' id='submit'> </form>
            </tr></th>";
            echo "</table>"; 
        }
      else {
      echo "<h1 style='font-family: verdana;'>All your orders have been fulfilled!</h1>";
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



</html>