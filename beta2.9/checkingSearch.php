<!DOCTYPE html>

<html>
<head>
<style>
img{
  width: 200px;
  height: 100px;
}
</style>
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

  <a href="./manager.php?checkingSearch">
  <div class="dashboard-button">
    Checking Search
  </div>
  </a>


<div class="dashboard">

  <form action="./php-calls/checkingSearch.inc.php" method="post">
    <input type= "text" name= "name" placeholder = "name">
    <input type="submit" name="submit" value="Search" />
  </form>
<!-- <?php
  require 'php-calls/checkingSearch.inc.php';
 ?> -->
</div>

</body>
</html>
