<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>title</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
  </head>
  <body>
  <div class = "header">
  </div>
  <a href="index.php"><button>Home</button></a>
  <div id="login-box">

    <div class="left">
      <h1>Sign up</h1>
      <b>
          <?php
          if(isset($_GET['error'])){
              if($_GET['error'] == "emptyfields"){
                echo "fill up all the fields";
              }
              else if($_GET['error'] == "invalidmail"){
                echo "invalid email";
              }

              else if($_GET['error'] == "passwordcheck"){
                echo "passwords don't match";
              }

              else if($_GET['error'] == "alreadyexists"){
                echo "username already exists";
              }
          }
         ?>

       </b>
      <form method = "post" action = "php-calls/register.inc.php">
      <input type="text" name="username" placeholder="Username" />
      <input type="text" name="email" placeholder="E-mail" />
      <input type="password" name="password" placeholder="Password" />
      <input type="password" name="password2" placeholder="Retype password" />
      <input type="submit" name="register-submit" value="register"/>

      </form>

    </div>


    <div class="right">
    <div class="rightimage">
      <img src ="images/baby-cap.jpg" height="300" width="450"/>
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
