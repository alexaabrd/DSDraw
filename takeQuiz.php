<?php

  session_start();
  require_once('functions.php');
  if (!isset($_SESSION['teacher'])) header('location:login.php');
  if ($_SESSION['teacher'] != false)  header('location:teacher.php'); 
$quizid = $_GET['id'];


?>



<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Home </title>
</head>

<body class="dsdraw">

  <h1>DSDRAW</h1>
    <a href="student.php"> Home </a>
  <div class="header">
    <form action="login.php" method="post">
     <label><?php echo "<h2> Hello, " . $_SESSION['first'] ."! </h2>"; ?><label>
     <input type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class="container">
   <form  class='style1' action="updateStudent.php" method="post">
     <label class='title-label'>
	<?php 
	  $quiz=getQuizInfo($quizid); 
	  echo "TAKE QUIZ for <br>";
	  echo $quiz[1]; //name
	  echo "<br>";
	  echo getName($quiz[2]); //classname
	?>
     </label>
    <?php

	//pull quiz information by $quizid from problems table
	//figure out how to submit all the problem within one quiz and grade them individually
    ?>
    </form>
  </div>

</body>
</html>
