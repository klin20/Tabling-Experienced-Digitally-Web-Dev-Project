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
  <title>Checkout</title>
  <link rel="stylesheet" type="text/css" href="navbar.css">
</head>
<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif')">
  <div class="navbar">
     <a style="font-size: 16px" href="index.php"><strong>T.E.D</strong></a>

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

<h2 id="dupe"> </h2>

      <h1 style="font-family: verdana;">Your Cart:</h1>
      <table style="width:50%">
    <tr>
      <th>Product</th>
      <th>Feature 1</th>
      <th>Feature 2</th>
      <th>Feature 3</th>
      <th>Feature 4</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Remove</th>
    </tr>
    <!-- <tr>
      <td></td>
      <td><input type="number" value="2" min="1"></td>
    </tr>
    <tr><td><button class="editbtn">edit</button></td></tr>
    <tr><td><button class="editbtn">edit</button></td></tr> -->

<?php
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

debug_to_console($_SESSION['price']);
if(isset($_COOKIE['price'])){
echo "<script> document.getElementById('dupe').innerHTML = 'Payment of $".sprintf('%0.2f', ($_COOKIE['price']/100))." Received!'</script> ";
setcookie('price', '', time() - 3600);
}

if(isset($_COOKIE["name"]) && isset($_COOKIE["token"])) { //change to checking db
   // echo "Logged in as ".$_COOKIE["name"];

define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PASSWORD','mysql');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

mysql_select_db('shoppers');
$result = mysql_real_escape_string($_COOKIE["name"]);
      $result = str_replace("@","At",$result);
      $result = str_replace(".","Dot",$result);


$query = "SELECT * FROM $result";

$resultq = mysql_query($query) or die($myQuery."<br/><br/>".mysql_error());
$pricesum = 0;
while ($row = mysql_fetch_array($resultq)){
    echo "<tr>";

    echo "<td>".($row['product'])."</td>";
    echo "<td>".($row['feature1'])."</td>";
    echo "<td>".($row['feature2'])."</td>";
    echo "<td>".($row['feature3'])."</td>";
    echo "<td>".($row['feature4'])."</td>";
    echo "<td>".($row['quantity'])."</td>";
    echo "<td>".($row['price'])."</td>";
    $pricesum += ($row['quantity']*$row['price']);
    echo "<td>";
    echo "<form  style='font-family: verdana;' class='ajax' action='delete_product_cart.php' method='post'>";
    echo "<input style='font-family: verdana;' name='product' type='hidden' value=\"".$row['product']."\">";
    echo "<input style='font-family: verdana;' name='feature1' type='hidden' value=\"".$row['feature1']."\">";
    echo "<input style='font-family: verdana;' name='feature2' type='hidden' value=\"".$row['feature2']."\">";
    echo "<input style='font-family: verdana;' name='feature3' type='hidden' value=\"".$row['feature3']."\">";
    echo "<input style='font-family: verdana;' name='feature4' type='hidden' value=\"".$row['feature4']."\">";
    echo "<input style='font-family: verdana;' name='quantity' type='hidden' value=\"".$row['quantity']."\">";
    echo "<input style='font-family: verdana;' name='price' type='hidden' value=\"".$row['price']."\">";
	echo "<input style='font-family: verdana;' name='id' type='hidden' value=\"".$row['product_id']."\">";
    echo "<input style='font-family: verdana;' type='submit' style='float:left' value='Remove' id='submit'>";

    echo "</form>";
    echo "</td>";
    echo "</tr>";


}
echo "</table>";
echo '<hr>';
echo "<h2 style='font-family: verdana; font-size:100%' >Shipping & handling: $0.00</h2>";
echo "<h2 style='font-family: verdana; font-size:100%' >Total before tax: $".sprintf('%0.2f', ($pricesum))."</h2>";
echo "<h2 style='font-family: verdana; font-size:100%' >NY State Tax: $".sprintf('%0.2f', (.08*$pricesum))."</h2>";
echo "<h2 style='font-family: verdana; font-size:100%' >Total: $".sprintf('%0.2f', (.08*$pricesum+$pricesum))."</h2>";

require_once('./config.php');
echo"
<form action='charge.php' method='post'>
  <script src='https://checkout.stripe.com/checkout.js' class='stripe-button'
          data-key=".$stripe['publishable_key']."
          data-description='Checkout'
          data-amount=".str_replace('.', '', (sprintf('%0.2f', (.08*$pricesum+$pricesum))))."
          data-locale='auto'></script>
  <input type='hidden' name='price' value=".str_replace('.', '', (sprintf('%0.2f', (.08*$pricesum+$pricesum)))).">
</form>";




//echo "<h3>"."</h3>"."<h5> Features: ".($row['feature1']).", ".($row['feature2']).", ".($row['feature3']).", ".($row['feature4']).", "."</h5>";
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