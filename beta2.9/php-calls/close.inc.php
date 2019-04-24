<?php
require 'dbh.inc.php';
loginCheck();
if(isset($_POST['submit'])){
    if(isset($_POST['account'])){

    $account = (int)$_POST['account'];
    $sql = "DELETE FROM accounts WHERE id = $account";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        die(mysqli_error($conn));
    }
    header("Location: ../dashboard.php?successDelete");

  }
  else{
    header("Location: ../dashboard.php?noAccSelected");
  }
}

function insertAccountOptions($conn){
  $id = getUserId();
  $sql = "SELECT * FROM accounts WHERE owner = $id";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }
  //  <option value="Yellow">Yellow</option>
  while($account = mysqli_fetch_assoc($result)){
    $accountId = $account['id'];
    $balance = getBalance($conn, $accountId);
    echo'<option value="'.$accountId.'">ID:'.$accountId.' $'.$balance.'</option>';
  }
}
?>
