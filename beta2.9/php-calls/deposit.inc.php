<?php
require 'dbh.inc.php';
loginCheck();

if(isset($_POST['submit'])){
  if(isset($_POST['amount'])){
    if(isset($_POST['account'])){

      $selected_val = (int)$_POST['account'];  // Storing Selected Value In Variable
      echo "You have selected :" .$selected_val;  // Displaying Selected Value

    $amount = $_POST['amount'];
    $account = $_POST['account'];
    echo "<br>" . $amount . " === " . $account;
    if($amount == null){
      header("Location: ../deposit.php?error=err");
      exit();
    } //end null
    if($amount < 0){
        header("Location: ../deposit.php?error=err");
      exit();
    }
    if (!(is_numeric($amount))){
      header("Location: ../deposit.php?error=err");
    exit();
    }
    $balance = getBalance($conn, $account);
    $newBalance = $balance + $amount;
    setBalance($conn,$account,$newBalance);
    header("Location: ../dashboard.php?success");

  } //post account end
  else{
      header("Location: ../deposit.php?error=notfilled1");
    exit();
  }
} //post amount end
  else{
    header("Location: ../deposit.php?error=notfilled2");
  exit();
  }
} //post submit end

?>
