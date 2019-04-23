<?php

  //check if user got here by button.
  //if they did not get here by button, redirect them to index page.

  if(!(isset($_POST['login-submit']))){
  header("Location: ../index.php?error=nobutton");
  exit();
  }

  //require imports dbh.inc.php to this location of the file
  //lets us use the $conn variable
  require 'dbh.inc.php';

  //login.php form set the $_POST['uid'] to what the user entered
  $uid = $_POST['username'];
  $password = $_POST['password'];

  //check for empty fields
  if(empty($uid) || empty($password)) {
    header("Location: ../login.php?error=emptyfields");
    exit();
  }

  //"stmt" methods are basically a secure way of doing MYSQL queries
  //$sql is the query
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../login.php?error=sqlerror2");
      exit();
    }
  mysqli_stmt_bind_param($stmt,"s",$uid);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  //user does not exist
  if(!($row = mysqli_fetch_assoc($result))){
    header("Location: ../login.php?error=nouser2");
    exit();
  }

  //checks hashed password to entered password
  $pwdCheck = password_verify($password, $row['password']);
  if ($pwdCheck == false) {
    header("Location: ../login.php?error=wrongpwd2");
    exit();
  }
  //the password they entered is correct
  //log the user into their account
  else if ($pwdCheck == true){
    //start a session so we can acces $_SESSION[] superglobal
    //grab the ID and name of the user we want to log in as
    //put it in the $_SESSION superglobal so we can use it later
    //later we will use this ID to see and edit the balance.
    $_SESSION['userId'] = $row['id'];
    $_SESSION['username'] = $row['username'];

    //redirect the user home
    header("Location: ../dashboard.php");
    exit();

  }
  else{
    header("Location: ../login.php?error=wrongpwd");
    exit();
  }
