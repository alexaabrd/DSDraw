<?php 
 require_once "functions.php";

 session_start();

if(!isset($_SESSION['user_id']) ) {
   login($_POST['username'], $_POST['password']); 

}
if( isset($_SESSION['teacher']) ) {
echo "here";
  if ($_SESSION['teacher'] == true)
    header("location:teacher.php");
  else header("location:student.php");
}

?>
