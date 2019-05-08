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

function trimDollar($amount){
  $string1 = "123.12345";
  $string2 = "12.123.12333";
  $string3 = "12.1";
  $string4 = "12"; //ok
  $string5 = "12.";
  $string6 = ".";
  $string7 = ".432";
  $string8 = ".222";


  $current = $amount;

  $count = substr_count($current,".");
  echo "count: ". $count;

  if($count == 0){
    return $current;
  }

  if($count != 1){
    return -1;
  }

  $pos = strpos($current, ".");
  $firsthalf = substr($current,0,$pos);
  $lasthalf = substr($current,$pos+1,strlen($current));
  echo "firsthalf: ".$firsthalf;
  echo "lasthalf: ". $lasthalf;

  if($lasthalf == null){
    return -1;
  }

  if(($firsthalf == null) && (strlen($lasthalf) > 2)){
    return -1;
  }

  if(strlen($lasthalf) > 2){
    return -1;
  }

  return $current;

}

function redirectManager($conn){
  if(isLoggedInAsManager($conn)){
      header("location:./manager.php");
  }
}

function isLessThan100k($number){
  if($number <= 100000){
    return true;
  }
  else{
    return false;
  }
}

function isShorterThan50($string){
  if(strlen($string) <= 50){
    return true;
  }
  else{
    return false;
  }
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

//gets account id by name
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

function insertIntoTrans($conn, $amount, $fromAcc, $toAcc, $type){
  // $from = getUsernameByAccountId($conn,$fromAcc);
  // $to = getUsernameByAccountId($conn,$toAcc);
  date_default_timezone_set("America/Los_Angeles");
  $time = date('Y-m-d')." ".date('H:m:s');
  $one = "one";
  $sql = "INSERT INTO trans(amount,fromAcc,toAcc,type,moment) VALUES ($amount,'$fromAcc','$toAcc','$type','$time')";
  echo "<br> sql  ". $sql;
  $result = mysqli_query($conn,$sql);

      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
      }

      echo "sql";
      return;

}

function getUsernameByAccountId($conn, $accountId){
  if($accountId == -1){
    return "N/A";
  }
  $id = getUserByAccountId($conn, $accountId);
  $name = getUsernameByUserId($conn, $id);
  return $name;
}

function getUsernameByUserId($conn, $id){
  $sql = "SELECT * FROM users WHERE id = $id";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }
  //  <option value="Yellow">Yellow</option>
  while($account = mysqli_fetch_assoc($result)){
    $name = $account['username'];
    return $name;
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
function getUser()
{
  echo $_SESSION['username'];
}

function loginCheck(){
  if(isLoggedIn()){
      //echo "logged in as " . $_SESSION['username']. getUserId() . "<br>";
    }
    else{
      header("location:./index.php?dush");
      exit();
    }
}

function managerLoginCheck($conn){
  if(isLoggedInAsManager($conn)){
      //echo "logged in as " . $_SESSION['username']. getUserId() . "<br>";
    }
    else{
      header("location:./index.php?man");
      exit();
    }
}

function isLoggedInAsManager($conn){
    if(isset($_SESSION['userId'])){
      if(strcasecmp("maNager", getUserName($conn)) == 0){
        return true;
      }
      else{
        return false;
      }
    }
    else{
      return false;
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

function getAccountStringTypeByNumberType($type){
  if($type == 0){
    return "Checkings";
  }
  else if ($type == 1){
    return "Savings";
  }
  else{
    return "error dbh.inc.php getAccountStringTypeByNumberType";
  }
}

function insertTable($conn,$userId){
  echo"<thead>
    <tr>
      <th>Type</th>
      <th>Amount</th>
      <th>From</th>
      <th>To</th>
      <th>Date</th>

    </tr>
  </thead>
  <tfoot>
    <tr>
    <th>Type</th>
    <th>Amount</th>
    <th>From</th>
    <th>To</th>
    <th>Date</th>

    </tr>
  </tfoot>";
  $sql = "SELECT * FROM trans";
  $result = mysqli_query($conn,$sql);
      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }
    while($trans = mysqli_fetch_assoc($result)){
      $fromAccountId = $trans['fromAcc'];
      $toAccountId = $trans['toAcc'];
      if(getUserByAccountId($conn,$fromAccountId) == $userId || getUserByAccountId($conn,$toAccountId) == $userId ){
        $type = $trans['type'];
        $amount = $trans['amount'];
        $from = $trans['fromAcc'];
        $from = getUsernameByAccountId($conn, $from);
        $to = $trans['toAcc'];
        $to = getUsernameByAccountId($conn, $to);
        $date = $trans['moment'];
        if($type == "Withdraw" || $type == "Deposit" ||  $type == "I-Deposit"){
          $from = "N/A";
          $to = "N/A";
        }

      echo
      '<tbody>
        <tr>
          <td>'.$type.'</td>
          <td>'.$amount.'</td>
          <td>'.$from.'</td>
          <td>'.$to.'</td>
          <td>'.$date.'</td>
        </tr>
      </tbody>';
    }
  }
}

//===============================================================
//auto payment functions
