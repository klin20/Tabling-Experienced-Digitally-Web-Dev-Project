<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'myDB');
define('DB_USER','root');
define('DB_PASSWORD','mysql');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

$db = mysql_select_db('users', $con);

$query="SELECT * FROM $_COOKIE[account_type] WHERE $_COOKIE[account_type].email='".$_COOKIE[name]."' LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Settings</title>
  <style>
  table, th, td {
      border: 1px solid black;
    }
  </style>
  <meta charset = "UTF-8">
  <title>Welcome Buyer</title>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="profile_picture.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="pp_js.js"></script>

</head>
<body style="background-image: url('https://78.media.tumblr.com/169831822d094fa0317de8d9b0b94fd4/tumblr_p0ls5q9gv01s8e2vio1_500.gif')">
    <div class="navbar">

      <a style="font-size: 16px" href="index.php"><strong>T.E.D</strong></a>

      <?php if($_COOKIE[account_type] == "organization"){
        echo "<a href='orders.php'>Pending Orders</a>
			<a href='archivedproducts.php'>Archived Products</a>";;
      } 
      ?>

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
        <div class="dropdown-content">
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
</div>
 <!--    <div class="profile">
         <div class="photo">
          <br><br>  
            <input type="file" accept="image/*">
            <div class="photo__helper">
                <div class="photo__frame photo__frame--circle">
                    <canvas class="photo__canvas"></canvas>
                    <div class="message is-empty">
                        <p class="message--desktop">Drop your photo here or browse your computer.</p>
                        <p class="message--mobile">Tap here to select your picture.</p>
                    </div>
                    <div class="message is-loading">
                        <i class="fa fa-2x fa-spin fa-spinner"></i>
                    </div>
                    <div class="message is-dragover">
                        <i class="fa fa-2x fa-cloud-upload"></i>
                        <p>Drop your photo</p>
                    </div>
                    <div class="message is-wrong-file-type">
                        <p>Only images allowed.</p>
                        <p class="message--desktop">Drop your photo here or browse your computer.</p>
                        <p class="message--mobile">Tap here to select your picture.</p>
                    </div>
                    <div class="message is-wrong-image-size">
                        <p>Your photo must be larger than 350px.</p>
                    </div>
                </div>
            </div>

            <div class="photo__options hide">
                <div class="photo__zoom">
                    <input type="range" class="zoom-handler">
                </div><a href="javascript:;" class="remove"><i class="fa fa-trash"></i></a>
            </div>

</div>
</div> -->
<h2 id="status"> </h2>
  <div class="personal-info">
    <h3 style="font-family: verdana; font-size: 100%;">Personal Information</h3>

 <fieldset style="width: 20%; background-color: #fafafa; opacity: 0.85">

    <form style="font-family: verdana; font-size: 100%; text-align: center;" class='ajax' action="editprofile.php" method="post">
      <h6 style="font-family: verdana;">Name:</h6>
      <input value="<?php echo $row['name'];?>" type="text" name="name">
      <h6 style="font-family: verdana;">Email:</h6>
      <input type="text" name="oldemail" id="oldemail">
      <h6 style="font-family: verdana;">Old Password:</h6>
      <input type="password" name="oldpass" id="oldpass">
      <h6 style="font-family: verdana;">New Password:</h6>
      <input type="password" name="newpass" id="newpass">
      <h6 style="font-family: verdana;">Confirm Password:</h6>
      <input type="password" name="confpass" id="confpass"><br>

      <br><input style="font-family: verdana;" type='submit' value='Save Changes' id='submit'>
      <input style="font-family: verdana;" type="reset" value="Cancel" id="cancel">
    </form>

    <form style="text-align: center;">
      <br><input style="font-family: verdana;" type="button" onclick="clickAlert()" value="Delete Account" id="delete">
    </form>
</fieldset>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
      $('form.ajax').on('submit', function(){
        var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};


        that.find('input[type!="submit"]').each(function(index, value){
          var that = $(this),
          name = that.attr('name'),
          value = that.val();
          console.log(this);
          data[name] = value;
        });

        console.log(data);

        $.ajax({
          url: url,
          type: type,
          data: data,
          success: function(response){

            if(response.localeCompare("suc".trim()) == 0){

            document.getElementById("status").innerHTML = "Successfully updated password!";
          }else if(response.localeCompare("notmatch".trim()) == 0){

            document.getElementById("status").innerHTML = "Passwords do not match!";
          } else if(response.localeCompare("emale".trim()) == 0){

            document.getElementById("status").innerHTML = "Successfully updated email!";
          }else if(response.localeCompare("wowza".trim()) == 0){

            document.getElementById("status").innerHTML = "Successfully updated email and password!";
          }
        }
      });


        return false;
      });
    </script>

    <script>
      function clickAlert() {
       //var c = confirm("Are you sure you want to delete your account?");
       if(confirm("Are you sure you want to delete your account?") == true){
        window.location = "delete_account.php";

       }
      }
    </script>

  </div>
</div>
</body>
</html>