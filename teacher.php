<?php
session_start();
 require_once "functions.php";

?>

<html>

<head>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Home </title>
</head>

<body class="dsdraw">

  <h1>DSDraw</h1>

  <div class="header">
    <form action="logout.php">
     <label><?php echo "<h2>Hello, " . $_SESSION['first'] ."!</h2>"; ?><label>
     <input type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class = "container">

    <div class="class-container">
      <form class='style1' action="manageClass.php" method="post">
        <label class='title-label'>Classes</label>
        <table style='width:100%'>
          <?php
            $classes = getClasses();

            if ($classes->num_rows == 0) {
              echo "You currently have no classes ";
	    } else {
              for ($i = 0; $i < $classes->num_rows; $i++) {
                $row = $classes->fetch_row();
                $classname = getName($row[0]);
	      //numstudents
	        echo "<tr>";
                echo "<td>" . $classname . "</td>";
                echo "<td><input class='button manageClass' type='submit' name='manageClass' value='". $row[0]."'></td>";
                echo "</tr>";
              }
	    }
          ?>
 	  <tr>
	    <td><input class="addValue" type="text" name="newClassName" ></td>
	    <td><input type="submit"  name="addClass" value="Add Class"></td>
	  </tr>
        </table>
      </form>
    </div>

    <div class="quiz-container">
      <form class='style1' action="quizDetail.php" method="post">
        <table style='width:100%'>
	  <label class='title-label'>Quizzes</label>
          <?php
	    $classes = getClasses();
            for ($i = 0; $i < $classes->num_rows; $i++) {
              $row = $classes->fetch_row();
              $classname = getName($row[0]);
              $quizzes= getQuiz($row[0]);
              for ($i = 0; $i < $quizzes->num_rows; $i++) {
                $row = $quizzes->fetch_row();
                echo "<tr>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $classname . "</td>";
                echo "<td><input class='button seeResults' type='submit' name='manageQuiz' value='". $row[0]."'></td>";
                echo "</tr>";
              }
            }
          ?>
        <tr><td></td><td></td><td><a href="newQuiz.php">Create New Quiz</a></td></tr>
        </table>
      </form>
    </div>

  </div>
</body>
</html>

