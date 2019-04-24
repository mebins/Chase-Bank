<head>
<style>
img{
  width: 400px;
  height: 300px;
}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>

<?php
require 'dbh.inc.php';
  echo "hello world2";
  if(isset($_POST['submit'])){

    if(!(isset($_POST['name']))){
      header("Location: ../checkingSearch.php?error=err");
      exit();
    }
    $name = $_POST['name'];
    if($name == NULL){
      //same as $_POST['name'];
      header("Location: ../checkingSearch.php?error=err");
      exit();
    };
      echo "hello world3";
    $userId = gets($conn, $name);;
    displayImageDepositsByUserId($conn, $userId);
  }

  function getUserIdByName($conn, $name){
    $sql = "SELECT * FROM users WHERE username = $name";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        die(mysqli_error($conn));
    }
    while($account = mysqli_fetch_assoc($result)){
      return $account['id'];
    }
  }

  function displayImageDepositsByUserId($conn, $userId){
    $sql = "SELECT * FROM uploads WHERE owner = $userId";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        die(mysqli_error($conn));
    }
    $counter = 0;
    while($upload = mysqli_fetch_assoc($result)){
      echo '<img src="../uploads/'.$upload['name'].'"/>';
      echo $upload['name']."<br>";
    }
  }


?>
