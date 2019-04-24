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

echo "you have: ".getNumberOfAccountsById($conn,getUserId()) ." accounts <br>";
echo "your total balance is: ".getTotalBalanceById($conn, getUserId()) ." dollars <br>";
function createAccount($conn, $ownerId){
  $defaultBalance = 0;
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
function displayAccounts($conn){
  $ownerId = getUserId();
  $sql = "SELECT * FROM accounts WHERE owner = $ownerId ";
  $result = mysqli_query($conn,$sql);
      if(!($result)){
    die(mysqli_error($conn));
    }

    while($account = mysqli_fetch_assoc($result)){
      // echo "<tr>";
      // echo "<td>".$account['id']."</td>";
      // echo "<td>".$account['balance']."</td>";
      // echo "</tr>";

      echo'
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Account ID: '.$account['id'].' </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">$'.$account['balance'].'
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
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
