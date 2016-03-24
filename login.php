<?php

  require_once "functions.php";

   if (isset($_POST['logout'])) logout();
   else checkSession();


?>





<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Login </title>
</head>
<body class="dsdraw">
<center>  <h1>DSDRAW</h1></center>
    <form class='style1'  action="dsDraw.php" method="post">
      <label class="title-label">Username:</label>
      <br>
      <input class="login-input" type="text" name="username">
      <br><br>
      <label class="title-label">Password:</label>
      <br>
      <input class="login-input" type="password" name="password">
<?php if ($_SESSION['error'] == true) echo "Invalid login credentials. Please try again."; ?> 
       <center><input type="submit" value="login"></center>
    </form>

</body>
</html>

<?php  
  $_SESSION['error'] = false; 
?>
