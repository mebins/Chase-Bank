<?php
  require 'dbh.inc.php';
  loginCheck();

  if(!(isset($_POST['submit']))){
    header("Location: ../createAuto.php?error=nobutton");
    exit();
  }

  if(!(isset($_POST['amount']))){
    header("Location: ../createAuto.php?error=fields");
    exit();
  }
  if(!(isset($_POST['from']))){
    header("Location: ../createAuto.php?error=fields");
    exit();
  }
  if(!(isset($_POST['to']))){
    header("Location: ../createAuto.php?error=fields");
    exit();
  }

  if(!(isset($_POST['seconds']))){
    header("Location: ../createAuto.php?error=fields");
    exit();
  }
    $amount = getAmount();

    $fromAcct = $_POST['from'];
    $timePeriod = getSeconds();
    $toAcct = getTo();

    if(!(isLessThan100k($amount))){
    header("Location: ../createAuto.php?error=tooBig");
    exit();
    }

    if(!(isLessThan100k($timePeriod))){
    header("Location: ../createAuto.php?error=tooBig");
    exit();
    }

    if(!(isLessThan100k($toAcct))){
    header("Location: ../createAuto.php?error=tooBig");
    exit();
    }

    if(getUserByAccountId($conn,$toAcct) == -1){
      header("Location: ../createAuto.php?error=userDNE");
    exit();
    }

    $fromAccountNewBalance = getBalance($conn, $fromAcct) - $amount;
    // if($fromAccountNewBalance < 0){
    //   header("Location: ../createAuto.php?error=amount");
    // exit();
    // }

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

function getSeconds(){
  $time = $_POST['seconds'];
  if($time == null){
    header("Location: ../createAuto.php?error=timeField");
    exit();
  } //end null
  if($time < 0){
      header("Location: ../createAuto.php?error=timeField");
    exit();
  }
  if (!(is_numeric($time))){
    header("Location: ../createAuto.php?error=timeField");
  exit();
  }
return $time;
}
function getTo(){
   $to = $_POST['to'];
   if($to == null){
     header("Location: ../createAuto.php?error=toField");
     exit();
   } //end null
   if($to < 0){
       header("Location: ../createAuto.php?error=toField");
     exit();
   }
   if (!(is_numeric($to))){
     header("Location: ../createAuto.php?error=toField");
   exit();
   }
 return $to;
}

function getAmount(){
  $amount = $_POST['amount'];
  if($amount == null){
    header("Location: ../createAuto.php?error=amountField");
    exit();
  } //end null
  if($amount < 0){
      header("Location: ../createAuto.php?error=amountField");
    exit();
  }
  if (!(is_numeric($amount))){
    header("Location: ../createAuto.php?error=amountField");
  exit();
  }
return $amount;
}

?>
