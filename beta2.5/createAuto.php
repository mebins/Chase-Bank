<!DOCTYPE html>
<?php
require './php-calls/dbh.inc.php';
?>

<form action="./php-calls/createAuto.inc.php" method="post">
    From: <select name="from">
    <?php
    require './php-calls/insertForms.inc.php';
    insertAccountOptions($conn);
     ?>
  </select>
<br>
To:  <input type= "text" name= "to" placeholder = "account">
<br>
Amount:  <input type= "text" name= "amount" placeholder = "amount">
<br>
Increment (SECONDS):  <input type= "text" name= "seconds" placeholder = "seconds">
<br>
<input type="submit" name="submit" value="create" />
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
