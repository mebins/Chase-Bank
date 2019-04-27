<?php
  require 'dbh.inc.php';
  loginCheck();
  if(!(isset($_POST['submit']))){
    header("Location: ../closeAuto.php?error=nobutton");
    exit();
  }

  if(!(isset($_POST['account']))){
    header("Location: ../closeAuto.php?error=fields");
    exit();
  }

      $AutoPaymentID = (int)$_POST['account'];
      $sql = "delete from autopayments where AutoPaymentID = $AutoPaymentID";
      $result = mysqli_query($conn,$sql);
      if(!($result)){
          die(mysqli_error($conn));
      }

      $sql = "DROP EVENT AutoPayment$AutoPaymentID";
      $result = mysqli_query($conn,$sql);
      if(!($result)){
          die(mysqli_error($conn));
      }

      header("Location: ../dashboard.php?successDelete");
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
