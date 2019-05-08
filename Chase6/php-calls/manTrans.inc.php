<?php
require 'dbh.inc.php';
managerLoginCheck($conn);
if(!(isset($_POST['submit'])))
  {
  header("Location: ./manager.php?error=button");
  exit();
  }

  if(!(isset($_POST['name'])) || $_POST['name'] == NULL)
  {
  header("Location: ./manager.php?searchTrans");
  exit();
  }

  $name = $_POST['name'];
  $userId = gets($conn, $name);


  function insertTable2($conn){
    insertTable($conn, $userId);
  }

  ?>
