<!DOCTYPE html>
<?php
require './php-calls/deposit.inc.php';
?>
<html>
<form action="./php-calls/deposit.inc.php" method="post">
  <select name="account">
    <?php
    insertAccountOptions($conn);
     ?>
  </select>
  <br>
  <input type= "text" name= "amount" placeholder = "amount">
  <input type="submit" name="submit" value="Deposit" />
</form>
</html>

<?php
//=========ERROR MESSAGE DIV HERE?===========
echo "<br>error message<br>";
if(isset($_GET['error'])){
if($_GET['error'] == "err"){
        echo "invalid input (sample error text)";
  }
}
?>
