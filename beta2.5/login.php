<!DOCTYPE html>
<?php
require './php-calls/dbh.inc.php';
  if (isLoggedIn()){
    header("Location: ./dashboard.php");
    exit();
  }
 ?>

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
        <?php
          if(isset($_GET['error'])){
              //we are brought inside here by, for example, header("Location: ../index.php?error=nouser2");
              if($_GET['error'] == "nouser" || $_GET['error'] == "nouser2" || $_GET['error'] == "wrongpwd" || $_GET['error'] == "wrongpwd2"){
                echo "<br> <b>*Invalid username or password.<b> <br> ";
              }
              else if ($_GET['error'] == "emptyfields"){
                echo "<br><b>*please fill out all the fields.<b> <br>";
              }
            }
          ?>
                  <form  method = "post" action = "php-calls/login.inc.php" class="user">
                    <div class="form-group">
                      <input type="text" name="username" placeholder="Username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                      <input type="password" name = "password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <hr>
                    <input type="submit" name="login-submit" value="login" class="btn btn-primary btn-user btn-block"/>
                  </form>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
