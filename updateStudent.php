<?php

  session_start();
  require_once('functions.php');
   if ($_POST['takeQuiz'] != "")       { $id = $_POST['takeQuiz']; header("location:takeQuiz.php?id=$id"); }

 $id = $_POST['seeResults'];
?>








<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Home </title>
</head>

<body class="dsdraw">

  <h1>DSDRAW</h1>

  <div class="header">
    <form action="logout.php">
     <label><?php echo "<h2> Hello, " . $_SESSION['first'] ."! </h2>"; ?><label>
     <input type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class="container">
    <form  class='style1' action="updateStudent.php" method="post">
      <label class='title-label'>
        <?php
          $quiz=getQuizInfo($id);
          echo "RESULTS for <br>";
          echo $quiz[1]; //name
          echo "<br>";
          echo getName($quiz[2]); //classname
        ?>
      </label>
      <table style='width:100%'>
	<?php
	  $results = getResults($id, $_SESSION['user_id']);
	  $points = 0;
	  $total = 0;
	    for ($i = 0; $i < $results->num_rows; $i++) {
		$row = $results->fetch_row();
		$score = $row[3];
		$poss = $row[4];
		$points += $score;
		$total += $poss;
		echo "<tr>";
		echo "<td> Problem " . $i . "</td>";
		echo "<td> " . $score . "/" . $poss . "</td>";
		echo "</tr>";
	    }
                echo "<tr>";
                echo "<td> <b>TOTAL</b> </td>";
		echo "<td><b> " . $points . "/" . $total . "</b></td>";
                echo "</tr>";
	?>
      </table>
    </form>
  </div>
</body>
</html>
