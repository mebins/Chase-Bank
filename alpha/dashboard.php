<!DOCTYPE html>

<?php
  require './php-calls/dashboard.php';
 ?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>
<div>

  <a href="./dashboard.php?createAccount">
  <div class="dashboard-button">
    Create account
  </div>
  </a>

  <a href="./deposit.php">
  <div class="dashboard-button">
    Make a deposit
  </div>
  </a>

  <a href="./dashboard.php?logout">
  <div class="logout-button" >
    LOGOUT
  </div>
</a>
</div>
<div class="bank-logo">
<img src="images/bank-logo.png" width=40% height=40%/>
</div>

<div class="dashboard">

<?php
  //I can hide this but meh.
  displayAccounts($conn,getUserId());
 ?>

</div>

</body>
</html>
