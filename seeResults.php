<?php

 session_start();
 require_once('functions.php');
  if (!isset($_SESSION['teacher'])) header('location:login.php');
    if ($_SESSION['teacher'] != true)  header('location:student.php');

?>









d>
 <link rel="stylesheet" type="text/css" href="css/theme.css">
   <title>DSDraw | Home </title>
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
     <form class='style1' action="manageClass.php" method="post">
        <label class='title-label'><?php echo getName($classid); ?>
        <input type='submit' class=' float trash' name='deleteClass' value='<?php echo $classid ?> '> </label>
        <table style='width:100%'>
          <?php
            $students = getStudents($classid);
            if ($students->num_rows == 0) {
              echo "Add students by their userID";
            } else {
              for ($i = 0; $i < $students->num_rows; $i++) {
                $row = $students->fetch_row();
                $uid = $row[1];
                $student = getStudentInfo($uid);
                echo "<tr>";
                echo "<td>" . $student[2] . " " . $student[3] . "</td>";
                echo "<td><input class='trash' type='submit' name='deleteStudent' value='". $uid."'></td>";
                echo "</tr>";
              }
            }
         ?>
 <tr>
            <td><input class="addValue" type="text" name="studentName" ></td>
            <td><input type="submit"  name="addStudent" value="Add Student"></td>
          </tr>
        </table>
        <?php if ($_SESSION['error'] == true) echo "That username does not exist please try again. Please try again.";
          ?>
        <input type="hidden" name="classid" value=" <?php echo $classid; ?>">
      </form>

  </div>


</body>
</html>
