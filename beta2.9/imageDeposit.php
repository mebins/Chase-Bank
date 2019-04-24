<!DOCTYPE html>
<?php
require './php-calls/imageDeposit.inc.php';
?>
<html>
<form action="./php-calls/imageDeposit.inc.php" method="post"  enctype ="multipart/form-data">
  <select name="account">
    <?php
    insertAccountOptions($conn);
     ?>
  </select>
  <br>
  <input type= "text" name= "amount" placeholder = "amount">
  <br>
  <input type = "file" name ="file">

  <br>

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
