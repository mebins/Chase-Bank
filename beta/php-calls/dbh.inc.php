<?php
session_start();
$servername = "localhost";
$dBUsername = "user";
$dBPassword = "";
$dBName = "bank";

$conn = mysqli_connect($servername,$dBUsername,$dBPassword,$dBName);

if(!$conn){
  echo "connection error";
  die("connection failed " .mysqli_connect_error());
}

function getBalance($conn,$accountId){
  $userId = getUserId();
  $sql = "SELECT * FROM accounts WHERE owner = $userId AND id = $accountId";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }
  //  <option value="Yellow">Yellow</option>
  while($account = mysqli_fetch_assoc($result)){
    $balance = $account['balance'];
    return $balance;
  }
}

function setBalance($conn, $accountId, $newBalance){
  $sql = "UPDATE accounts SET balance = $newBalance WHERE id = $accountId";
  mysqli_query($conn,$sql);
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }
}

function isLoggedIn(){
  if(isset($_SESSION['userId'])){
    return true;
  }
  else{
    return false;
  }
}

  function hello(){
    echo "hello world";
  }

  function getUserId(){
    if(isset($_SESSION['userId'])){
      return $_SESSION['userId'];
    }
    else{
      return -999;
    }
}

function loginCheck(){
  if(isLoggedIn()){
      echo "logged in as " . $_SESSION['username']. getUserId() . "<br>";
    }
    else{
      header("location:./dashboard.php?dush");
      exit();
    }
}
