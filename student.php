<?php 
session_start();
 require_once "functions.php";
  if (!isset($_SESSION['teacher'])) header('location:login.php');
  if ($_SESSION['teacher'] != false)  header('location:teacher.php');
?>

<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Home </title>
</head>

<body class="dsdraw">

  <h1>DSDRAW</h1>

  <div class="header">
    <form action="login.php" method="post">
     <label><?php echo "<h2> Hello, " . $_SESSION['first'] ."! </h2>"; ?></label>
     <input class='float' type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class="container">
    <form  class='style1' action="updateStudent.php" method="post">
      <label class='title-label'>Your Quizzes</label>
      <table style='width:100%'>
	<?php
          $classes = getClasses();
	  if ($classes->num_rows == 0) {
		echo "You currently have no quizzes";
	  } else {
	      for ($i = 0; $i < $classes->num_rows; $i++) {
		$row = $classes->fetch_row();
		$classname = getName($row[0]);
		$quizzes= getQuiz($row[0]);
		for ($j = 0; $j < $quizzes->num_rows; $j++) {
		  $row = $quizzes->fetch_row();
		  echo "<tr>";
		  echo "<td>" . $row[1] . "</td>";
		  echo "<td>" . $classname . "</td>";
		  $quizResults = getResults($row[0], $_SESSION['user_id']);
		  if ($quizResults->num_rows == 0) echo "<td><input class=' button takeQuiz' type='submit' name='takeQuiz' value='". $row[0]."'></td>";
		 else echo "<td><input class=' button seeResults' type='submit' name='seeResults' value='". $row[0]."'></td>";
		  echo "</tr>";
		}
	      }
	  }
        ?>
      </table>
    </form>
  </div>
</body>
</html>
