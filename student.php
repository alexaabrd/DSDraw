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

  <div class="header">
    <form action="logout.php">
     <label><?php echo "<h2>Hello, " . $_SESSION['first'] ."!</h2>\n"; ?><label>
     <input type="submit" name="logout" value="Logout">
    </form>
  </div>

  <div class="container">



        <?php
        $tasks = getClasses();


        if ($tasks->num_rows == 0) {echo "You currently have no classes " . $_SESSION['user_id'];}
        else {
          for ($i = 0; $i < $tasks->num_rows; $i++) {
            $row = $tasks->fetch_row();
            $name = getName($row[0]);
                echo "<div class='tclass'>" . $name ;
            $quiz= getQuiz($row[0]);
             for ($i = 0; $i < $quiz->num_rows; $i++) {
                           $row = $quiz->fetch_row();
                        echo "<div class='tsubclass'>" .$row[1] . "</div>";
            }
              echo "</div>";
         }
}
        ?>

</div>
</body>
</html>
