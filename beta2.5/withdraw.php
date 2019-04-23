<!DOCTYPE html>
<?php
require './php-calls/deposit.inc.php';
?>
<html>
<form action="./php-calls/withdraw.inc.php" method="post">
  <input type= "text" name= "amount" placeholder = "amount">
    <select name="account">
      <?php
      insertAccountOptions($conn);
       ?>
    </select>
  <input type="submit" name="submit" value="Withdraw" />
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
