<?php
require 'dbh.inc.php';


if(isLoggedIn()){
    echo "logged in as " . $_SESSION['username']. getUserId() . "<br>";
  }
  else{
    header("location:./index.php?dush");
    exit();
  }

//set by clicking the logout button
if (isset($_GET['logout'])) {;
  logout();
}

if (isset($_GET['createAccount'])) {;
  createAccount($conn,getUserId());
}


function createAccount($conn, $ownerId){
  $defaultBalance = 0;
  $defaultBalance = mt_rand(1, 1000);
  $sql = "INSERT INTO accounts(owner,balance) VALUES ($ownerId,$defaultBalance)";
  $result = mysqli_query($conn,$sql);

      if($result)
    {

    }
    else
    {
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }

    header("location:./dashboard.php?dush");
    exit();
}

//returns the un-mysqli_fetch_assoced results
function displayAccounts($conn, $ownerId){
  $sql = "SELECT * FROM accounts WHERE owner = $ownerId ";
  $result = mysqli_query($conn,$sql);
      if($result)
    {

    }
    else
    {
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }

    while($account = mysqli_fetch_assoc($result)){
      // echo "<tr>";
      // echo "<td>".$account['id']."</td>";
      // echo "<td>".$account['balance']."</td>";
      // echo "</tr>";

      echo'<div class="dashboard-account">
          <div class="account-content">
          Account ID: '.$account['id'].' : Balance
          <div class="account-balance">
          '.$account['balance'].'
          </div>
        </div>
      </div>';
    }

}

function logout(){
  session_start();
  session_unset();
  session_destroy();
  header("location:./index.php");
}

?>
