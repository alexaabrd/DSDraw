<?php

require_once "functions.php";


session_start();

if ($_SESSION["teacher"] == true) createQuiz($_POST["class"],$_POST["name"], $_POST["q"], $_POST["data"]);
else { 
  submitQuiz($_POST["qid"], $_POST["pid"],   $_POST["grade"], $_POST["poss"]); 
}

/*echo "<br><br><br>";

echo $_POST["qid"];
echo "<br>";

echo $_POST["pid"];
echo "<br>";
echo $_POST["solution"];
echo "<br>";
echo $_POST["answer"];
echo "<br>";

echo $_POST["grade"];
echo "<br>";

echo $_POST["poss"];
echo "<br><br><br>";

*/


?>
