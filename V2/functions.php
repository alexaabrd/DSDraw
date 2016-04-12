<?php

require_once "connect.php";


function connect() {
 $conn = new mysqli(servername, username, password);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
 
  if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
    echo "<p>You must access this page from on campus through dias11.</p></body></html>";
    die ();
  }

  $conn->query("use abird1;"); 
  return $conn;
}



function checkSession() {
  session_start();
  if(isset($_SESSION['user_id']) )
   header("Location: dsDraw.php");
}




function login($u, $p) {
 $conn = connect();
 
 $query = "select * from logins where username = '" . $u .
		"' AND password = '" . $p . "';";
 $result = $conn->query($query);

  if ($result->num_rows != 1) {
   header("Location: login.php");
   $_SESSION['error'] = true;
   $conn->close();
   return false;
  }

 session_start();
 $row=$result->fetch_row();

 $id = $row[0];

 $query = "select * from users where login = " . $id . ";";
 $result = $conn->query($query);
 $row=$result->fetch_row();

 $_SESSION['user_id'] = $row[0];
 $_SESSION['first'] = $row[2];
 $_SESSION['error'] = false;
 $_SESSION['teacher'] = $row[4];

  $conn->close();
  return true;
}












function createAccount($f,$l,$u,$p,$e,$t) {
  $conn = connect();
        session_start();
 $query = "select * from users where username ='" .$u . "';";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
        $_SESSION['create'] = false;
            header("Location: newUser.php");
        $conn->close();
        return;
        }
 $query = "insert into logins (username,password) VALUES ('" . $u . "', '" . $p . "');";
 $conn->query($query);
 $query = "select * from logins where username ='" .$u . "' AND password = '" . $p . "';";
  $result = $conn->query($query);
  $row = $result->fetch_row();

 $query = "insert into users (login, first,last,username,teacher) VALUES (" . $row[0] . ", '" . $f . "', '" . $l . "', '" . $u . "', '" . $t . "');";

if ($conn->query($query) ) { login($u, $p); }
else {  $_SESSION['error'] = true;
header("Location: newUser.php");
    $conn->close();
        return;

}
  $conn->close();

}










function getProblems($id) {
  $conn = connect();
 $query = "select * from problems where quizid = ". $id . ";";

  $result = $conn->query($query);
  $conn->close();
  return $result;
}

function getClasses() {
  $conn = connect();

  if ($_SESSION['teacher']) 
     $query = "select * from classrooms where deleted = false AND owner = " . $_SESSION['user_id'] . ";";
  else $query = "select * from enrollment where userID = " . $_SESSION['user_id'] . ";";

  $result = $conn->query($query);
  $conn->close();
  return $result;
}


function getStudents($class) {
  $conn = connect();
  $query = "select * from enrollment where deleted = false AND classID = " .$class . ";";
  $result = $conn->query($query);
  $conn->close();
  return $result;
}


function getStudentInfo($uid) {
  $conn = connect();
  $query = "select * from users where ID = " .$uid . ";";
  $result = $conn->query($query);
  $row = $result->fetch_row();

  $conn->close();
  return $row;

}


function getName($id) {
  $conn = connect();

  $query = "select name from classrooms where ID = " . $id . ";";
  
  $result =  $conn->query($query);
  $row = $result->fetch_row();

  $conn->close();
  return $row[0];
}


function getQuiz($class) {
  $conn = connect();
  $query = "select * from quiz where classID = " .$class . ";";

  $result = $conn->query($query);
  $conn->close();
  return $result;
}

function getQuizInfo($id) {
  $conn = connect();
  $query = "select * from quiz where ID = " .$id . ";";
  $result = $conn->query($query);
  $row = $result->fetch_row();

  $conn->close();
  return $row;
}


function getResults($qid, $uid) {
 $conn = connect();
 $query = "select * from results where quizID = " .$qid . " AND userid = ". $uid . " ORDER BY problemId;";
 $result = $conn->query($query);
 $conn->close();
 return $result;
}

function getQuizResults($qid) {
 $conn = connect();
 $query = "select * from results where quizID = " .$qid . " ORDER BY problemId;";
//	echo "<br>" .$query . "<br>";
 $result = $conn->query($query);
 $conn->close();
 return $result;
}


function addClass($name, $id) {
 $conn = connect();

 $query = "select * from classrooms where name = '" . $name . "' AND owner = " . $id . " ;";
 $result = $conn->query($query);
 if ($result->num_rows > 0) {
   $row = $result->fetch_row();
   $query = "update classrooms set deleted = false where id = " . $row[0] . " ;";
   $result = $conn->query($query);
 } else {
   $query = "insert into classrooms (owner,name,deleted) values (" . $id .",'" . $name . "',false);";
   $conn->query($query);
   $query = "Select * from classrooms where name = '" . $name . "' AND owner = " . $id .";";
   $class =  $conn->query($query);
   $row = $class->fetch_row();
   }
 $conn->close();
 return $row[0];
}

function deleteStudent($uid, $cid) {
 $conn = connect();
 $query = "update enrollment set deleted = 1 where userid = " . $uid . " AND classid = ". $cid . ";";
 $result = $conn->query($query);
 $conn->close();

}

function addStudent($uid, $cid) {
  $conn = connect();
 $query = "Select * from users where username = '" . $uid . "';";
 $result = $conn->query($query);
  if ($result->num_rows == 0) {
	$_SESSION['error'] =true;
	$conn->close();
	return;
  }
 $row = $result->fetch_row();
 $id = $row[0];
 $query = "select * from enrollment where classid = " . $cid . " AND userid = " . $id . " ;";
 $result = $conn->query($query);
 if ($result->num_rows > 0) {
 $query = "update enrollment set deleted = 0 where userid = " . $id . " AND classid = ". $cid . ";";
 $conn->query($query);
  }
 else {
  $query = "insert into enrollment values (" . $cid . ",". $id . ", 0);";
  $conn->query($query);

 }
 $conn->close();
}



function deleteClass($id) {
 $conn = connect();

  $query = "update classrooms set deleted = 1 where id = " . $id . ";";
  echo $query;
  $conn->query($query);


 $conn->close();

}

function logout() {
session_start();
session_destroy();
 unset($_SESSION['user_id']);
 unset($_SESSION['first']);
}





function createQuiz($cid, $name, $q, $ret) {

 $conn = connect();

 $query = "insert into quiz (name,classid) values ('" . $name . "', " . $cid . ");";

//  echo "<br>" . $query;
  $conn->query($query);
   $query = "select * from quiz where name = '" . $name . "' AND  classId = ". $cid .";";
//  echo "<br>" . $query;
 $result = $conn->query($query);
 $row = $result->fetch_row();
 $id = $row[0];

 $query = "insert into problems (quizid, question, solution) values (" . $id . ", '" . $q . "', '" . $ret ."');";
//  echo "<br>" . $query;
$conn->query($query);
 $conn->close();

}


function submitQuiz($qid, $pid, $grade, $poss) {
 $conn = connect();

 $query = "insert into results (quizid, userid,problemID,score,total) values (" . $qid . ", "  .  $_SESSION['user_id'] . ", " . $pid . ", " . $grade . ", " . $poss . ");";

  $conn->query($query);
  $conn->close();
}


?>


