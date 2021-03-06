<?php
  require 'dbh.inc.php';
  loginCheck();

  if(isset($_POST['submit']))
  {
  if(!(isset($_POST['submit']))){
    header("Location: ../transfer.php?error=button");
    exit();
  }

  if(!(isset($_POST['amount']))){
    header("Location: ../transfer.php?error=amount");
    exit();
  }
  if(!(isset($_POST['from']))){
    header("Location: ../transfer.php?error=fields");
    exit();
  }
  if(!(isset($_POST['to']))){
    header("Location: ../transfer.php?error=fields");
    exit();
  }
    $amount = getAmount();

    $fromAccountId = $_POST['from'];
    $toAccountId = $_POST['to'];

    if(getUserByAccountId($conn,$toAccountId) == -1){
      header("Location: ../transfer.php?error=userDNE");
      exit();
    }

    if(!(isLessThan100k($amount))){
    header("Location: ../transfer.php?error=tooBig");
    exit();
    }

    // if(!(isLessThan100k($to))){
    // header("Location: ../transfer.php?error=tooBig");
    // exit();
    // }
    if(trimDollar($amount) == -1){
      header("Location: ../transfer.php?error=amount");
    exit();
    }
    $amount = trimDollar($amount);
    $fromAccountNewBalance = getBalance($conn, $fromAccountId) - $amount;
    // if($fromAccountNewBalance < 0){
    //   header("Location: ../transfer.php?error=funds");
    // exit();
    // }

  transfer($conn, $fromAccountId, $toAccountId, $amount);
  header("Location: ../dashboard.php?success");

}//END IFFSET POST SUBMIT INTERNAL TRANSFER

// else if(isset($_POST['exsubmit'])){
//   $amount = getAmount();
//   $fromAccountId = $_POST['from'];
//   $toAccountId = $_POST['to'];
//   echo "id: ". $toAccountId;
//   $toAccountId = getUserByAccountId($conn, $toAccountId);
//   if($toAccountId == -1){
//     header("Location: ../transfer.php?error=AccountNotFound");
//     exit();
//   }
// }
else{ //NO BUTTON
  echo "fail";
}

function getAmount(){
  $amount = $_POST['amount'];
  if($amount == null){
    header("Location: ../transfer.php?error=amount");
    exit();
  } //end null
  if($amount < 0){
      header("Location: ../transfer.php?error=amount");
    exit();
  }
  if (!(is_numeric($amount))){
    header("Location: ../transfer.php?error=amount");
  exit();
  }
return $amount;
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
