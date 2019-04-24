<?php
require './php-calls/dbh.inc.php';
  if (isLoggedIn()){
    header("Location: ./dashboard.php");
    exit();
  }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>title</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
  </head>
  <body>
  <div class = "header">
  </div>
  <a href="index.html"><button>Home</button></a>
  <div id="login-box">
    <div class="left">
      <h1>Login</h1>
      <b>
        <?php
        if(isset($_GET['error'])){
            //we are brought inside here by, for example, header("Location: ../index.php?error=nouser2");
            if($_GET['error'] == "nouser" || $_GET['error'] == "nouser2" || $_GET['error'] == "wrongpwd" || $_GET['error'] == "wrongpwd2"){
              echo "<br> No username/password match <br> ";
            }
            else if ($_GET['error'] == "emptyfields"){
              echo "<br> please fill out all the fields <br>";
            }
          }
        ?>
      </b>

      <form method = "post" action = "php-calls/login.inc.php">
      <input type="text" name="username" placeholder="Username" />
      <input type="password" name="password" placeholder="Password" />

      <input type="submit" name="login-submit" value="login"/>
      </form>
    </div>


    <div class="right">
    <div class="rightimage">
      <img src ="images/chase-login.png" height="350" width="350"/>
    </div>
    </div>
</div>

    <!---<form method = "post" action = "register.php">
       <table>
         <tr>
           <td>Username:</td>
           <td><input type = "text" name = "username" class = "textInput"> </td>
         </tr>

         <tr>
           <td>email:</td>
           <td><input type = "email" name = "email" class = "textInput"> </td>
         </tr>

         <tr>
           <td>password:</td>
           <td><input type = "password" name = "password" class = "textInput"> </td>
         </tr>

         <tr>
           <td>confirm password:</td>
           <td><input type = "password" name = "password2" class = "textInput"> </td>
         </tr>

         <tr>
           <td>Username:</td>
           <td><input type = "submit" name = "register_btn" value = "Register"> </td>
         </tr>
       </table>
    </form>
    !-->

  </body>
</html>
