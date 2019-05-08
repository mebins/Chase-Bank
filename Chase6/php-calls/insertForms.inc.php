<?php
loginCheck();
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

function insertAutoOptions($conn){
  $id = getUserId();
  $sql = "SELECT * FROM autopayments WHERE owner = $id";
  $result = mysqli_query($conn,$sql);
  if(!($result)){
      die(mysqli_error($conn));
  }
  //  <option value="Yellow">Yellow</option>
  while($auto = mysqli_fetch_assoc($result)){
    $id = $auto['AutoPaymentID'];
    $amount = $auto['Amount'];
    $time = $auto['TimePeriod'];
    $toAccountId = $auto['ToAccountFK'];
    $toUserId = getUserByAccountId($conn, $auto['ToAccountFK']);
    $toArray = getUserByUserId($conn,$toUserId);
    if($toUserId == -1){
      $toName = "(UNKNOWN USER)";
    }
    else{
    $toName = $toArray['username'];
  }
    echo'<option value="'.$id.'">$:'.$amount.' every '.$time.' seconds to '.$toName.'</option>';
  }
}
?>
