<!DOCTYPE html>
<?php
require './php-calls/deposit.inc.php';
?>
<html>
<b> make an internal transfer <b>: <br>
<form action="./php-calls/transfer.inc.php" method="post">
    From: <select name="from">
    <?php
    insertAccountOptions($conn);
     ?>
  </select>
  <br>
  To: <select name="to">
  <?php
  insertAccountOptions($conn);
   ?>
</select>
<br>
Amount:  <input type= "text" name= "amount" placeholder = "amount">
<br>
  <input type="submit" name="submit" value="Transfer" />
</form>

<form action="./php-calls/transfer.inc.php" method="post">
<br>
 <b>or make an explicit (external) transfer</b>
<br>
<form action="./php-calls/transfer.inc.php" method="post">
    From: <select name="from">
    <?php
    insertAccountOptions($conn);
     ?>
  </select>
<br>
Account ID:  <input type= "text" name= "to" placeholder = "account">
<br>
Amount  <input type= "text" name= "amount" placeholder = "amount">
<br>
<input type="submit" name="submit" value="Transfer" />
</form>
</html>
<?php
//=========ERROR MESSAGE DIV HERE?===========
echo "<br>error message here<br>";
if(isset($_GET['error'])){
if($_GET['error'] == "err"){
        echo "invalid input (sample error text)";
  }
}
?>
