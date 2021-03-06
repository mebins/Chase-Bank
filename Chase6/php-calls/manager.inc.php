<?php
require 'dbh.inc.php';
  managerLoginCheck($conn);

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

      if(isset($_GET['search'])){
        search();
      }

      if(isset($_GET['searchTrans'])){
        searchTrans();
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

  function searchTrans(){
    echo'<form action="./manSearchTrans.php" method="post">
        <input type= "text" name= "name" placeholder = "Username">
        <input type="submit" name="submit" value="Search Transactions" />
      </form>';
  }

  function search(){
    echo'<form action="./php-calls/checkingSearch.inc.php" method="post">
        <input type= "text" name= "name" placeholder = "Username">
        <input type="submit" name="submit" value="Search Uploads" />
      </form>';
  }
function email($conn, $sort){
  echo "<thead>
    <tr>
      <th>Email</th>
      <th>Username</th>
      <th>Total balance</th>
      <th>Accounts open</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
    <th>Email</th>
    <th>Username</th>
    <th>Total balance</th>
    <th>Accounts open</th>
    </tr>
  </tfoot>";
  $sql = "SELECT * FROM users ORDER BY email $sort";
  $result = mysqli_query($conn,$sql);
      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }
    while($user = mysqli_fetch_assoc($result)){
      echo
      '<tbody>
        <tr>
          <td>'.$user['email'].'</td>
          <td>'.$user['username'].'</td>
          <td>'.getTotalBalanceById($conn, $user['id']).'</td>
          <td>'.getNumberOfAccountsById($conn, $user['id']).'</td>
        </tr>
      </tbody>';
  }
}
function balance($conn,$sort){
  echo "<thead>
    <tr>
      <th>Balace</th>
      <th>Name</th>
      <th>Email</th>
      <th>Type</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
    <th>Balace</th>
    <th>Name</th>
    <th>Email</th>
    <th>Type</th>
    </tr>
  </tfoot>";
  $sql = "SELECT * FROM accounts ORDER BY balance $sort";
  $result = mysqli_query($conn,$sql);
      if(!($result)){
        die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
    }

    while($account = mysqli_fetch_assoc($result)){

      $owner = getUserByUserId($conn, $account['owner']);
      $type = $account['type'];
      $type = getAccountStringTypeByNumberType($type);


  echo
  '<tbody>
    <tr>
      <td>'.$account['balance'].'</td>
      <td>'.$owner['username'].'</td>
      <td>'.$owner['email'].'</td>
      <td>'.$type.'</td>
    </tr>
  </tbody>';
  }
}

  function name($conn, $sort){
    echo "<thead>
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Total balance</th>
        <th>Accounts open</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
      <th>Username</th>
      <th>Email</th>
      <th>Total balance</th>
      <th>Accounts open</th>
      </tr>
    </tfoot>";
      $sql = "SELECT * FROM users ORDER BY username $sort";
      $result = mysqli_query($conn,$sql);
          if(!($result)){
            die(mysqli_error($conn));    // Thanks to Pekka for pointing this out.
        }
        while($user = mysqli_fetch_assoc($result)){

          echo
          '<tbody>
            <tr>
              <td>'.$user['username'].'</td>
              <td>'.$user['email'].'</td>
              <td>'.getTotalBalanceById($conn, $user['id']).'</td>
              <td>'.getNumberOfAccountsById($conn, $user['id']).'</td>
            </tr>
          </tbody>';
      }
  }
?>
