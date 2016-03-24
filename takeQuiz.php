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
<script type="text/javascript" src="script/canvas.js"></script>
<script type="text/javascript" src="script/grader.js"></script>

   <title>DSDraw | Take Quiz </title>
</head>

<body class="dsdraw">

 <h1><a href="student.php"><-Go Back to DsDraw Home</a></h1>
  
  <div class="header">
    <form action="login.php" method="post">
     <label><?php echo "<h2> Hello, " . $_SESSION['first'] ."! </h2>"; ?></label>
     <input class='float' type="submit" name="logout" value="Logout">
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


<div id="submitArea">
<h3>
Instructions
</h3>
<p>
  <b>Double click to add a new object type.</b> Types are 1. root, 2. single-linked node, 3. double-linked node, and 4. array. These are grey, blue, green and purple respectively. The default is a single-linked node. To change modes of adding, use the shift key and the number associated with the object listed above. For example, to add a double-linked node, press shift-3 and then double click. To add a node with data enter the data in the text box before double clicking in the canvas.
</p>
<p>
  <b>To delete an object, right click or use the button.</b> The button clears all shapes on the canvas.
</p>
<p>
  <b>To create a previous connection, use the checkbox.</b> Make sure the checkbox is clicked before trying to make the connection.
</p>
<p>
  <b>To create connections between nodes press the caps lock key.</b> There are two modes, object and connection. In object mode you cna move objects around. In connection mode, you click one object then another to create a connection between them. Note: for a next connection, click on the object you want to give the next to, then the next object.
</p>
<p>
  <b>To delete a connection use the buttons.</b> You cna either undo the last line or connection created or clear all lines.
</p>
<p>
 <b>****After Button Pesses Move Mouse Into Canvas***</b>
</p>



QUESTION GOES HERE

<center>
<div>
  Enter Node Data:
  <input id="text" type="text">

</div>

<div>
  Enter Node Data for Array:
  <input id="val1" type="text" style="width: 30px">
  <input id="val2" type="text" style="width: 30px">
  <input id="val3" type="text" style="width: 30px">
  <input id="val4" type="text" style="width: 30px">
</div>

<div class="">
  <input id="clearshapes" type="submit" name="clear shapes" value="clear shapes" />
  <input id="clear" type="submit" name="clear lines" value="clear lines" />
  <input id="undo" type="submit" name="undo line" value="undo line" />
  <input id="prevCheck" type="checkbox">Make Connections Previous </label>

</div>



<div>
  <canvas class="" id="canvas1" width="800" height="400" style="border:1px solid #d3d3d3;">
    Your browser does not support the HTML5 canvas tag.
  </canvas>
</div>

<div>
<input id='gradeMe' type="submit" name="gradeMe" value="Submit to be Graded">
</div>

</center>
</div> <!--submitarea -->
  </div> <!--container -->


</body>
</html>
