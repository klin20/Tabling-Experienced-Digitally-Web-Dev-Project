<!DOCTYPE HTML>
<html>
<head>
	<title>Celeste</title>
	<link rel="stylesheet" type="text/css" href="style-sign.css">

 <script type="text/javascript" language="javascript">
 function submitform(){
 document.getElementById('myForm').submit();
 }

 
 </script>
 	<style>
		h1 {
 			animation-duration: 2s;
  			animation-name: slidein;
		}

		@keyframes slidein {
  			from {
    			margin-left: 100%;
    			width: 300%; 
  			}

  			to {
    			margin-left: 0%;
    			width: 100%;
  			}
		}

		h5{
			animation-duration: 3s;
  			animation-name: anotherslidein;
		}

		@keyframes anotherslidein {
  			from {
    			margin-right: 100%;
    			width: 300%; 
  			}

  			to {
    			margin-right: 0%;
    			width: 100%;
  			}
		}

		#Sign-In{
			animation-duration: 5s;
			animation-name: wowza;
		}

		@keyframes wowza {
  			from {
    			margin-top: 100%;
    			width: 300%; 
  			}

  			to {
    			margin-top: 0%;
    			width: 100%;
  			}
		}

		#Sign-In a:hover {
    		font-size: 150%;
		}

		#Sign-Up a:hover{
			font-size: 150%;
		}

	</style>

<style>
.scroll-left {
 height: 660px;	
 overflow: hidden;
 position: relative;
}
.scroll-left .inner {
 position: absolute;
 width: 100%;
 height: 25%;
 opacity: 0.8;
 z-index: -1;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);	
 transform:translateX(100%);
 /* Apply animation to this element */	
 -moz-animation: scroll-left 8s linear infinite;
 -webkit-animation: scroll-left 8s linear infinite;
 animation: scroll-left 8s linear infinite;
}
/* Move it (define the animation) */
@-moz-keyframes scroll-left {
 0%   { -moz-transform: translateX(100%); }
 100% { -moz-transform: translateX(-100%); }
}
@-webkit-keyframes scroll-left {
 0%   { -webkit-transform: translateX(100%); }
 100% { -webkit-transform: translateX(-100%); }
}
@keyframes scroll-left {
 0%   { 
 -moz-transform: translateX(100%); /* Browser bug fix */
 -webkit-transform: translateX(100%); /* Browser bug fix */
 transform: translateX(100%); 		
 }
 100% { 
 -moz-transform: translateX(-100%); /* Browser bug fix */
 -webkit-transform: translateX(-100%); /* Browser bug fix */
 transform: translateX(-100%); 
 }
}
</style>

</head>

<body id="body-color" onload="submitform()">
	<!-- style="background-image:url('ted_bg.gif')" -->
	<div class="scroll-left" id="PageTitle">
		<h1 style="font-family: verdana; text-align: center; font-size: 400%;">T.E.D</h1>
		<h5 style="font-family: verdana; text-align: center;"><em><strong>T</strong>ABLING <strong>E</strong>XPERIENCED <strong>D</strong>IGITALLY.</em></h5>
		<div class="inner">
			<img src="https://scontent-lga3-1.xx.fbcdn.net/v/t35.0-12/24946510_1684895041529162_1603554025_o.png?oh=209f97f00009ab32511563b2765bf93c&oe=5A342946" alt="photo">
		</div>




<?php

	define('DB_HOST', 'localhost');
	define('DB_NAME', 'myDB');
	define('DB_USER','root');
	define('DB_PASSWORD','mysql');

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
	
	if(!mysql_select_db('users', $con)){
		$sql = 'CREATE DATABASE users';
		mysql_query($sql, $con);
		$db = mysql_select_db('users', $con);
		$query = sprintf("SELECT %s FROM users.tables","organization");
		$resultq = mysql_query($query, $con);
		$query = sprintf("CREATE TABLE %s(
			email VARCHAR(255) NOT NULL PRIMARY KEY,
			name VARCHAR(40) NOT NULL,
			pass VARCHAR(40) NOT NULL,
			reg_time VARCHAR(40) NOT NULL,
			token INT(255) NOT NULL)","organization");
		mysql_query($query, $con);
		$query = sprintf("SELECT %s FROM users.tables","student");
		$resultq = mysql_query($query, $con);
		$query = sprintf("CREATE TABLE %s(
			email VARCHAR(255) NOT NULL PRIMARY KEY,
			name VARCHAR(40) NOT NULL,
			pass VARCHAR(40) NOT NULL,
			reg_time VARCHAR(40) NOT NULL,
			token INT(255) NOT NULL)","student");
		mysql_query($query, $con);
		echo 
				'<div id="Sign-In">
				<a href="/login.html">Log In!</a>
				</div>
				<div id="Sign-Up">
				<a href="/sign-up.html">Sign Up!</a>
				</div>';
	}else{
		$db = mysql_select_db('users', $con);
//			$query = "SELECT $_COOKIE[account_type] FROM users.tables";
//			$result = mysql_query($query, $con);
		if(isset($_COOKIE["name"]) && isset($_COOKIE["token"])) {				
			$queryStr = sprintf("SELECT * FROM %s where email = '%s'",mysql_real_escape_string($_COOKIE[account_type]),mysql_real_escape_string($_COOKIE[name]));
			$query = mysql_query($queryStr) or die(mysql_error());
			$row = mysql_fetch_array($query);
			if($row['token'] != $_COOKIE['token']){
				setcookie("name", "", time() - 3600);
				setcookie("token", "", time() - 3600);
				setcookie("account_type", "", time() - 3600);
				header("Location: /notloggedin.html"); // Redirect browser to not logged in page 
				exit();
			}
			echo 'Logged in as '.$_COOKIE["name"].'<br>
				<a href="/'.$_COOKIE["account_type"].'_landing.php">Landing Page</a>';
		} else {
			echo 
				'<div style="font-family: verdana; text-align: center; font-size:75%" id="Sign-In">
				<a href="/login.html"><strong>LOG IN</strong></a>
				</div>
				<div style="font-family: verdana; text-align: center; font-size:75%" id="Sign-Up">
				<a href="/sign-up.html"><strong>SIGN UP</strong></a>
				</div>';
		}
	}

	
?>
 
 
 	<form method="GET" action="student_landing.php" id="student" name="student">
    </form>
    <form method="GET" action="organization_landing.php" id="organization" name="organization">
    </form>
 		  
 <script type="text/javascript" language="javascript">
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}



 if(getCookie("account_type")=='student'){
 document.student.submit();
}else if(getCookie("account_type")=='organization'){
	document.organization.submit();

}



 </script>

</body>
</html> 