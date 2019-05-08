<?php
require 'dbh.inc.php';
loginCheck();


  if(!(isset($_POST['submit'])))
  {
    header("Location: ../createAccount.php?error=button");
    exit();
  }

  if(!(isset($_POST['type']))){
    header("Location: ../createAccount.php?error=button");
    exit();
  }

    $type = $_POST['type'];
  $ownerId = getUserId();
  $defaultBalance = 0;
  $sql = "INSERT INTO accounts(owner,balance,type) VALUES ($ownerId,$defaultBalance,$type)";
  $result = mysqli_query($conn,$sql);

      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
      }

    echo "hello " . $type;

    header("location:../dashboard.php?success");
    exit();

?>
