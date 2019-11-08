
<?php
// set the expiration date to one hour ago
setcookie("name", "", time() - 3600);
setcookie("token", "", time() - 3600);
setcookie("account_type", "", time() - 3600);
?>


 <html>
 <head>
 <title>Checkout </title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <script type="text/javascript" language="javascript">
 function submitform(){
 document.getElementById('myForm').submit();
 }
 
 </script>
 
 </head>
 <body onload="submitform()">
 
 			    <form method="GET" action="login.html" id="member_signup" name="member_signup">
      <input type="hidden" name="signout" value="yes"><br>
    </form>
 		  
 <script type="text/javascript" language="javascript">
 document.member_signup.submit();
 </script>
 			   
 </body>
 </html>