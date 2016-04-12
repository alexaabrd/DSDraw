<?php 
 require_once "functions.php";

 session_start();

 if ($_POST['submit']=="create") { createAccount($_POST['first'], $_POST['last'], $_POST['username'], $_POST['password'], $_POST['email'], $_POST['teacher']); }
 if(!isset($_SESSION['user_id']) ) {
   login($_POST['username'], $_POST['password']); 
  }
  if( isset($_SESSION['teacher']) ) {
    if ($_SESSION['teacher'] == true)
      header("location:teacher.php");
    else header("location:student.php");
}
?>
