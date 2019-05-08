<head>
<style>
* {
  text-align: center;
  margin: auto;
  font-size: 25px;
  background-color: #eaeefa;
}
  img{
    width: 600px;
    height: 300px;
  }

  .imageGroup{
    margin: 35px;
  }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>

<?php
require 'dbh.inc.php';
if(!(isLoggedInAsManager($conn))){
header("Location: ../index.php?err");
}
  if(isset($_POST['submit'])){
    if(!(isset($_POST['name']))){
      header("Location: ../manager.php?earch");
      exit();
    }
    $name = $_POST['name'];
    if($name == NULL){
      //same as $_POST['name'];
      header("Location: ../manager.php?search");
      exit();
    };
      echo'<br><a href="../manager.php">Go Back</a><br>';
    $userId = gets($conn, $name);
    displayImageDepositsByUserId($conn, $userId);
  }

  function getUserIdByName($conn, $name){
    $sql = "SELECT * FROM users WHERE username = $name";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        die(mysqli_error($conn));
    }
    if($account = mysqli_fetch_assoc($result)){
      return $account['id'];
    }
    else{
      return -1;
    }
  }

  function displayImageDepositsByUserId($conn, $userId){
    $sql = "SELECT * FROM uploads WHERE owner = $userId";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
      echo"user not found";
  ;
      exit();
    }
    $counter = 0;
    while($upload = mysqli_fetch_assoc($result)){
      echo "<div class = 'imageGroup'>";
      echo "Amount: ".$upload['amount']."<br>";
      echo '<img src="../uploads/'.$upload['name'].'"/>';
      echo "<br>";
      echo"<div>";

    }
  }


?>
