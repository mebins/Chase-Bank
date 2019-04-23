<?php
session_start();
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "bank2";

$LIMIT = 0;

$conn = mysqli_connect($servername,$dBUsername,$dBPassword,$dBName);

if(!$conn){
  echo "connection error";
  die("connection failed " .mysqli_connect_error());
}

function getUserName($conn){
if (!(isLoggedIn())){
  return "LOGGED OFF";
  }

  $userId = getuserId();
  $sql = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }

  while($account = mysqli_fetch_assoc($result)){
    return $account['username'];
  }

}

function getUserByUserId($conn, $userId){
  $sql = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }

  while($account = mysqli_fetch_assoc($result)){
    return $account;
  }
}

function gets($conn, $name){
  $sql = "SELECT * FROM users WHERE (username = '$name')";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }

  while($account = mysqli_fetch_assoc($result)){
    return $account['id'];
  }
}
  //returns -1 if not found
  function getUserByAccountId($conn, $AccountId){
    $sql = "SELECT * FROM accounts WHERE id = $AccountId";
    $result = mysqli_query($conn,$sql);
    $count = 0;
    if(!($result)){
        die(mysqli_error($conn));
    }

    if($account = mysqli_fetch_assoc($result)){
      return $account['owner'];
    }
    else{
      return -1;
    }

  }

  // while($account = mysqli_fetch_assoc($result)){
  //   //fetch from that array boi
  //   $userId = $account['owner'];
  //   $sql = "SELECT * FROM users WHERE owner = $userId";
  //   $result = mysqli_query($conn,$sql);
  //   if(!($result)){
  //       die(mysqli_error($conn));
  //   }
  //   while($user = mysqli_fetch_assoc($result)){
  //     return $user;
  //   }
  // }

function getBalance($conn,$accountId){
  $sql = "SELECT * FROM accounts WHERE id = $accountId";
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

function transfer($conn, $fromAccountId, $toAccountId, $amount){
  $fromNewBalance = getBalance($conn, $fromAccountId) - $amount;
  setBalance($conn, $fromAccountId, $fromNewBalance);

  $toNewBalance = getBalance($conn, $toAccountId) + $amount;
  setBalance($conn, $toAccountId, $toNewBalance);
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
      header("location:./index.php?dush");
      exit();
    }
}

function getNumberOfAccountsById($conn, $id){
$sql = "SELECT * FROM accounts WHERE owner = $id";
$accounts = 0;
$result = mysqli_query($conn,$sql);
if(!($result)){
    die(mysqli_error($conn));
}
//  <option value="Yellow">Yellow</option>
while($account = mysqli_fetch_assoc($result)){
$accounts = $accounts + 1;
  }
  return $accounts;
}

function getTotalBalanceById($conn, $id){
$sql = "SELECT * FROM accounts WHERE owner = $id";
$total = 0;
$result = mysqli_query($conn,$sql);
if(!($result)){
    die(mysqli_error($conn));
}
//  <option value="Yellow">Yellow</option>
while($account = mysqli_fetch_assoc($result)){
  $total = $total + $account['balance'];
}
  return $total;
}
