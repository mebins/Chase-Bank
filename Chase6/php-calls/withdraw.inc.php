<?php
require 'dbh.inc.php';
loginCheck();


  if(!(isset($_POST['submit'])))
  {
    header("Location: ../withdraw.php?error=button");
    exit();
  }

  if(!(isset($_POST['amount']))){
    header("Location: ../withdraw.php?error=wamount");
    exit();
  }
  if(!(isset($_POST['account']))){
    header("Location: ../withdraw.php?error=fields");
    exit();
  }

    $selected_val = (int)$_POST['account'];  // Storing Selected Value In Variable
    echo "You have selected :" .$selected_val;  // Displaying Selected Value

    $amount = $_POST['amount'];
    $account = $_POST['account'];

    if(!(isLessThan100k($amount))){
    header("Location: ../withdraw.php?error=tooBig");
    exit();
    }

    echo "<br>" . $amount . " === " . $account;
    if($amount == null){
      header("Location: ../withdraw.php?error=wamount");
      exit();
    } //end null
    if($amount < 0){
        header("Location: ../withdraw.php?error=wamount");
      exit();
    }
    if (!(is_numeric($amount))){
      header("Location: ../withdraw.php?error=wamount");
    exit();
    }

    if(trimDollar($amount) == -1){
      header("Location: ../withdraw.php?error=wamount");
    exit();
    }
    $amount = trimDollar($amount);

    $balance = getBalance($conn, $account);
    $newBalance = $balance - $amount;
    if($newBalance < 0){
    header("Location: ../withdraw.php?error=funds");
    exit();
    }
    setBalance($conn,$account,$newBalance);
    insertIntoTrans($conn, $amount, $account, $account, 'Withdraw');
    header("Location: ../dashboard.php?success");


?>
