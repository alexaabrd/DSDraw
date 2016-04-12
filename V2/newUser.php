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
<center>  <h1 style='color:darkgray' >DSDRAW</h1></center>
    <form class='style1'  action="dsDraw.php" method="post">
      <label class="title-label">First Name</label>
      <br>
      <input class="login-input" type="text" name="first">
      <br><br>
      <label class="title-label">LastNAme</label>
      <br>
      <input class="login-input" type="text" name="last">
	<br><br>
      <label class="title-label">Username</label>
      <br>
      <input class="login-input" type="text" name="username">
      <br><br>
      <label class="title-label">Password:</label>
      <br>
      <input class="login-input" type="password" name="password">
      <br><br>
      <label class="title-label">are you a teacher?:</label>
	<center>
	<input type="radio" name="teacher" value="true" > yes<br>
	<input type="radio" name="teacher" value="false" checked> no<br>
	</center>
	<br><br>
<?php   if ($_SESSION['error'] == true) echo "Something went wrong. Please Try again."; 
	if ($_SESSION['create'] == false) echo "User already exists";
?>
       <center><input type="submit" name='submit' value="create"></center>
    </form>
<center> <a href="login.php">            Back to Login </a></center>
</body>
</html>

<?php
  $_SESSION['error'] = false;

  $_SESSION['create'] = true;
?>

