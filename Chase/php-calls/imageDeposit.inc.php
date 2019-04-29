<?php
require 'dbh.inc.php';
loginCheck();

if(isset($_POST['submit'])){

  if(!(isset($_POST['amount']))){
    header("Location: ../imageDeposit.php?error=amount");
     exit();
    }
    if(!(isset($_POST['account']))){
      header("Location: ../imageDeposit.php?error=fields");
       exit();
    }

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.',$fileName);
    print_r($file);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg', 'png');

    if(!(in_array($fileActualExt, $allowed))){
            header("Location: ../imageDeposit.php?error=invalidFile");
          exit();
    }
      if(!($fileError == 0)){
        header("Location: ../imageDeposit.php?error=errFileUpload");
      exit();
      }

    $fileNameNew = uniqid('',true).".".$fileActualExt;
    $fileDestination = "../uploads/".$fileNameNew;
    move_uploaded_file($fileTmpName,$fileDestination);


    $amount = $_POST['amount'];

    if(!(isLessThan100k($amount))){
    header("Location: ../imageDeposit.php?error=tooBig");
    exit();
    }

    $account = $_POST['account'];
    echo "<br>" . $amount . " === " . $account;
    if($amount == null){
      header("Location: ../imageDeposit.php?error=amount");
      exit();
    } //end null
    if($amount < 0){
        header("Location: ../imageDeposit.php?error=amount");
      exit();
    }
    if (!(is_numeric($amount))){
      header("Location: ../imageDeposit.php?error=amount");
    exit();
    }
    $balance = getBalance($conn, $account);
    $newBalance = $balance + $amount;

    if(trimDollar($amount) == -1){
      header("Location: ../imageDeposit.php?error=amount");
    exit();
    }
    $amount = trimDollar($amount);

    setBalance($conn,$account,$newBalance);
    $userId = getUserId();
    $sql = "INSERT INTO uploads(owner,name,amount) VALUES ('$userId','$fileNameNew','$amount')";
    $result = mysqli_query($conn,$sql);
        if(!($result))  {
          die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
          exit();
      }


    header("Location: ../dashboard.php?success");

} //post submit end


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
