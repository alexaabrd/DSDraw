<?php

  session_start();
  require_once('functions.php');
  if (!isset($_SESSION['teacher'])) header('location:login.php');
  if ($_SESSION['teacher'] != true)  header('location:student.php');
  


?>



<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
 <script type="text/javascript" src="script/canvas.js"></script>
 <script type="text/javascript" src="script/grader.js"></script>
   <title>DSDraw | Create Quiz </title>
</head>

<body class="dsdraw">

 <a href="student.php"><h1><-Go Back to DsDraw Home</h1> </a>


  <div class="header">
    <form action="login.php" method="post">
     <label><?php echo "<h2> Hello, " . $_SESSION['first'] ."! </h2>"; ?></label>
     <input class='float' type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class="container">



   <form  class='style1' action="" method="post">
     <label class='title-label'>
        Create Quiz
     </label>
	<center><select>
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
	</select></center>
   </form>



<div id="submitArea">

 <label class='title-label'>
        Question
     </label>
  <center>
	<textArea style="width: 400px; height:100px;">type your question here.</textarea>
  </center>

<br><br>
 <label class='title-label'>
        Answer
     </label>

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
<input id='createMe' type="submit" onClick='createMe()'  name="createMe" value="Create Quiz">
</div>
</center>
<div id="gradeMe"> </div>
</div> <!--submitarea -->

 
  </div>

</body>
</html>

