<?php
//user got here legitimately through button

if (!(isset($_POST['register-submit']))){
  header("Location: ../index.php?signup=success2");
  exit();
}

require 'dbh.inc.php'; //connects to the database
//lets us use the $conn variable from dbh.inc.php file

//get everything from form submited in signup.php file
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordRepeat = $_POST['password2'];

//check for empty fields
if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
  header("Location: ../register.php?error=emptyfields&uid= ".$username."&mail=".$email);
  exit();
}

//check for valid email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: ../register.php?error=invalidmail&uid=".$username);
    exit();
}

//check for similar passwords
if($password !== $passwordRepeat){
  header("Location: ../register.php?error=passwordcheck&uid=".$username."&mail=".$email);
  exit();
}
//check if name exists in db
//'stmt' methods are just a way to run sql queries
$sql = "SELECT username FROM users where username=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
  //if name exists in db, redirect to url
  header("Location: ../register.php?error=sqlerror");
  exit();
}

//no error, check for taken name
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt); //runs info inside database
//now check for matches...
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);

if ($resultCheck > 0){ //name already exists
  header("Location: ../register.php?error=alreadyexists");
  exit();
}

//create the account by inserting user info into database
$sql = "INSERT INTO users(username, email, password) VALUES (?, ?, ?)";

if(!mysqli_stmt_prepare($stmt,$sql)){
  header("Location: ../register.php?error=sqlerror");
  exit();
}
//insert into database with stmt
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
mysqli_stmt_bind_param($stmt, "sss", $username,$email,$hashedPwd);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
header("Location: ../index.php?signup=success");

mysli_stmt_close($stmt);
mysqli_close($conn);
