<!DOCTYPE html>
<?php
require './php-calls/close.inc.php';
?>
<html>
<form action="./php-calls/close.inc.php" method="post">
  <b> Warning: closing the account will remove ALL of its funds! </b><br>
    <select name="account">
      <?php
      insertAccountOptions($conn);
       ?>
    </select>
  <input type="submit" name="submit" value="Close" />
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
