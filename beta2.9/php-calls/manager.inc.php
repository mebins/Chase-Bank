<?php
require 'dbh.inc.php';

function insertDashboard($conn){
    if(isset($_GET['balanceDesc'])){
      balance($conn,"DESC");
      }

    if(isset($_GET['balanceAsc'])){
      balance($conn,"ASC");
      }

      if(isset($_GET['nameAsc'])){
      name($conn,"ASC");
      }

      if(isset($_GET['emailAsc'])){
      email($conn,"ASC");
      }

      if(isset($_GET['checkingSearch'])){
      require 'checkingSearch.inc.php';
      }

      // if(isset($_GET['accountsDesc'])){
      // accounts($conn,"DESC");
      // }
      //
      // if(isset($_GET['accountsAsc'])){
      // accounts($conn,"ASC");
      // }
  }
function email($conn, $sort){
  $sql = "SELECT * FROM users ORDER BY email $sort";
  $result = mysqli_query($conn,$sql);
      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }
    while($user = mysqli_fetch_assoc($result)){

    echo'<div class="dashboard-account">
      <div class="account-content">

      Username: '.$user['username'].' Email:

      <div class="account-balance">

      '.$user['email'].'

      </div>
    </div>
  </div>';
  }
}
function balance($conn,$sort){
  $sql = "SELECT * FROM accounts ORDER BY balance $sort";
  $result = mysqli_query($conn,$sql);
      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }

    while($account = mysqli_fetch_assoc($result)){

      $owner = getUserByUserId($conn, $account['owner']);

  echo'<div class="dashboard-account">
      <div class="account-content">

      Owner: '.$owner['username'].' || Balance:

      <div class="account-balance">

      '.$account['balance'].'

      </div>
    </div>
  </div>';
  }
}

  function name($conn, $sort){
      $sql = "SELECT * FROM users ORDER BY username $sort";
      $result = mysqli_query($conn,$sql);
          if(!($result)){
            die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
        }
        while($user = mysqli_fetch_assoc($result)){

        echo'<div class="dashboard-account">
          <div class="account-content">

          Email: '.$user['email'].' Username:

          <div class="account-balance">

          '.$user['username'].'

          </div>
        </div>
      </div>';
      }
  }
?>
