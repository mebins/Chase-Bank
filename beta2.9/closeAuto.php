<!DOCTYPE html>
<?php
require './php-calls/deposit.inc.php';
?>

<form action="./php-calls/closeAuto.inc.php" method="post">
    From: <select name="account">
    <?php
    insertAutoOptions($conn);
     ?>
  </select>

<input type="submit" name="submit" value="Remove" />
</form>
</html>
<?php
insertAutoOptions($conn);
//=========ERROR MESSAGE DIV HERE?===========
echo "<br>error message here<br>";
if(isset($_GET['error'])){
if($_GET['error'] == "err"){
        echo "invalid input (sample error text)";
  }
}
?>
