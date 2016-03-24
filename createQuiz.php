<?php

  session_start();
  require_once('functions.php');
  if (!isset($_SESSION['teacher'])) header('location:login.php');
  if ($_SESSION['teacher'] != true)  header('location:student.php');
  


?>



<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
 <script type="text/javascript" src="script/createQuiz.js"></script>
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
        Create Quiz
     </label>
	<select>
    <?php
	$classes = getClasses($_SESSION['user_id']);	
	for ($i = 0; $i < $classes->num_rows; $i++) {
                $row = $classes->fetch_row();
                echo "<option>";
		echo getName($row[0]);
		echo "</option>";
	}
	
        //pull quiz information by $quizid from problems table
        //figure out how to submit all the problem within one quiz and grade them individually
    ?>
    </select>
    <select id='numQuestions' name='numQuestions' onChange="fillForm">
    <option value='1'>1</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='4'>4</option>
    <option value='5'>5</option>
    </select>

    <div id='questions'>
    </div>

    </form>
  </div>

</body>
</html>

