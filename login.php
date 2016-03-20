<?php

require_once "functions.php";

checkSession();

?>





<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Login </title>
</head>
<body class="dsdraw">
<center><h1></h2></center>
    <form id="login"  action="dsDraw.php" method="post">
      <label class="login-label">Username:</label>
      <br>
      <input class="input" type="text" name="username">
      <br><br>
      <label class="login-label">Password:</label>
      <br>
      <input class="input" type="password" name="password">
<?php if ($_SESSION['error'] == true) echo "Invalid login credentials. Please try again."; ?> 
       <center><input type="submit" value="login"></center>
    </form>

</body>
</html>

<?php  
  $_SESSION['error'] = false; 
?>
