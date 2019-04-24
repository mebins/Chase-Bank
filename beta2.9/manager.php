<!DOCTYPE html>

<?php
  require './php-calls/manager.inc.php';
 ?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>
<div>

  <a href="./manager.php?emailAsc">
  <div class="dashboard-button">
    email (ASC)
  </div>
  </a>

  <a href="./manager.php?nameAsc">
  <div class="dashboard-button">
    name (ASC)
  </div>
  </a>

  <a href="./manager.php?balanceDesc">
  <div class="dashboard-button">
    IndividualBalance (DESC)
  </div>
  </a>

  <a href="./checkingSearch.php">
  <div class="dashboard-button">
    Checking Search
  </div>
  </a>

  <!--
I can't do this without some kind of sorting algorithm
  <a href="./manager.php?accountsDesc">
  <div class="dashboard-button">
    # of accounts (DESC)
  </div>
  </a>

  <a href="./manager.php?accountsAsc">
  <div class="dashboard-button">
    # of accounts (ASC)
  </div>
  </a> -->


<div class="dashboard">

<?php
  insertDashboard($conn);
 ?>

</div>

</body>
</html>
