<?php

 session_start();
 require_once('functions.php');
  if (!isset($_SESSION['teacher'])) header('location:login.php');
    if ($_SESSION['teacher'] != true)  header('location:student.php');


$quizid = $_POST['seeResults'];
$quiz = getQuizInfo($quizid);
$students = getQuizResults($quizid);

?>




<html>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw|SeeClassResults </title>
</head>

<body class="dsdraw">

 <a href="student.php"><h1>Go Back to DsDraw Home</h1> </a>

  <div class="header">
    <form action="login.php" method="post">
     <label><?php echo "<h2> Hello, " . $_SESSION['first'] ."! </h2>"; ?></label>
     <input class='float' type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class="container">
     <form class='style1' action="" method="post">
        <label class='title-label'><?php echo $quiz[1]; ?></label>
	<br>
       <!-- <input type='submit' class=' float trash' name='deleteClass' value='<?php echo $classid ?> '> </label>-->
        <table style='width:100%'>
          <?php
            if ($students->num_rows == 0) {
              echo "Noone has taken this quiz yet";
            } else {
              for ($i = 0; $i < $students->num_rows; $i++) {
                $row = $students->fetch_row();
                $uid = $row[0];
                $student = getStudentInfo($uid);
                echo "<tr>";
                echo "<td>" . $student[2] . " " . $student[3] . "</td>";
		echo "<td> -----------------------------------</td>";
                echo "<td>";
		   $results = getResults($quizid, $uid);
		   	echo "<table>";
		   for ($i = 0; $i < $results->num_rows; $i++) {
			 $row = $results->fetch_row();
	                $score = $row[3];
        	        $poss = $row[4];
                	$points += $score;
	                $total += $poss;
        	        $temp = $i +1;
			echo "<tr>";
	                echo "<td style='width:100px;'> Problem " . $temp . "</td>";
        	        echo "<td> " . $score . "/" . $poss . "</td>";
                	echo "</tr>";
		   }
	                echo "<tr>";
	                echo "<td> <b>TOTAL</b> </td>";
	                echo "<td><b> " . $points . "/" . $total . "</b></td>";
        	        echo "</tr>";
			echo "</table>";
		   echo "</td>";
                echo "</tr>";
              }
            }
         ?>
 <tr>
        </table>
        <?php if ($_SESSION['error'] == true) echo "That username does not exist please try again. Please try again.";
          ?>
        <input type="hidden" name="classid" value=" <?php echo $classid; ?>">
      </form>

  </div>


</body>
</html>
