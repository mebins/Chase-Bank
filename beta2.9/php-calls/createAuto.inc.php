<?php
  require 'dbh.inc.php';
  loginCheck();

  if(!(isset($_POST['submit']))){
    header("Location: ../createAuto.php?error=nobutton");
    exit();
  }

  if(!(isset($_POST['amount']))){
    header("Location: ../createAuto.php?error=erramount");
    exit();
  }
  if(!(isset($_POST['from']))){
    header("Location: ../createAuto.php?error=err");
    exit();
  }
  if(!(isset($_POST['to']))){
    header("Location: ../createAuto.php?error=err");
    exit();
  }

  if(!(isset($_POST['seconds']))){
    header("Location: ../createAuto.php?error=errsec");
    exit();
  }
    $amount = getAmount();

    $fromAcct = $_POST['from'];
    $toAcct = $_POST['to'];
    $timePeriod = $_POST['seconds'];

    $fromAccountNewBalance = getBalance($conn, $fromAcct) - $amount;
    if($fromAccountNewBalance < 0){
      header("Location: ../createAuto.php?error=err2");
    exit();
    }

    $id = getUserId();
    $sql = "insert into autopayments (FromAccountFK, ToAccountFK, Amount, TimePeriod,owner) Values ($fromAcct, $toAcct, $amount, $timePeriod,$id)";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
      die(mysqli_error($conn));
    }

    $lastID = $conn->insert_id;

    $sql = "CREATE EVENT AutoPayment$lastID ON SCHEDULE EVERY $timePeriod SECOND DO CALL transfer($fromAcct,$toAcct,$amount)";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
      die(mysqli_error($conn));
    }

  header("Location: ../dashboard.php?success");
  exit();

  // header("Location: ../dashboard.php?success");

//END IFFSET POST SUBMIT INTERNAL TRANSFER

// else if(isset($_POST['exsubmit'])){
//   $amount = getAmount();
//   $fromAccountId = $_POST['from'];
//   $toAccountId = $_POST['to'];
//   echo "id: ". $toAccountId;
//   $toAccountId = getUserByAccountId($conn, $toAccountId);
//   if($toAccountId == -1){
//     header("Location: ../createAuto.php?error=AccountNotFound");
//     exit();
//   }
// }

function getAmount(){
  $amount = $_POST['amount'];
  if($amount == null){
    header("Location: ../createAuto.php?error=err");
    exit();
  } //end null
  if($amount < 0){
      header("Location: ../createAuto.php?error=err");
    exit();
  }
  if (!(is_numeric($amount))){
    header("Location: ../createAuto.php?error=err");
  exit();
  }
return $amount;
}

?>
