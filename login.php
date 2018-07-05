<?php
	session_start();

  include ("assets/plugin/google/recaptchalib.php");
  include("config.php");

		if(isset($_SESSION['username']))  {
		header("Location: index.php");
		return;
	}

	$error = "";
	$errorcolor = "red";

  if(isset($_POST['login'])) {
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);

        $username = stripslashes($username);
        $password = stripslashes($password);

        $username = mysqli_real_escape_string($db, $username);
        $password = mysqli_real_escape_string($db, $password);

        $password = md5($password);

        $sql = "SELECT * FROM userlogin WHERE username='$username' LIMIT 1";
        $query = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($query);
        $id = $row['id'];
        $db_password = $row['password'];
        $admin = $row['admin'];

        if(isset($_POST['g-recaptcha-response']))
          $captcha=$_POST['g-recaptcha-response'];

        if(!$captcha){
          $error = "<p><small>Please complete the recaptcha</small></p>";
        }
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$privatekey&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        if($response['success'] == false)
        {
          $error = "<p><small>Please complete the recaptcha</small></p>";
        }
        else 
        {
            if($password == $db_password) {
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $id;
                if($admin == 1) {
                    $_SESSION['admin'] = 1;
                }
                header("Location: index.php");
            } else {
                $error = "<p><small>Username or password is incorrect</small></p>";
            }
          }

  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="login, signin">

    <title>Login Page &mdash; PepperSSL</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="../assets/css/core.min.css" rel="stylesheet">
    <link href="../assets/css/app.min.css" rel="stylesheet">
    <link href="../assets/css/style.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
    <link rel="icon" href="../assets/img/favicon.png">
  </head>

  <body>


    <div class="row no-gutters min-h-fullscreen bg-white">
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-image: url(../assets/img/gallery/11.jpg)" data-overlay="5">

        <div class="row h-100 pl-50">
          <div class="col-md-10 col-lg-8 align-self-end">
            <img src="../assets/img/logo_white.png" alt="...">
            <br><br><br>
            <h4 class="text-white">SSLChecker is the best SSL checker available online.</h4>
            <p class="text-white">Use this system to monitor all of your SSL certificates from any authority. Created by Robin Schmidt - All rights reserved.</p>
            <br><br>
          </div>
        </div>

      </div>



      <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
        <div class="px-80 py-30">
          <h4>Login</h4>
          <p><small>Sign into your account</small></p>
          <br>

          <form class="form-type-material" role="form" action="login.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="text" class="form-control" name="username" id="username">
              <label for="username">Username</label>
            </div>

            <div class="form-group">
              <input type="password" class="form-control" name="password" id="password">
              <label for="password">Password</label>
            </div>

            <div class="form-group">
              <div class="g-recaptcha" <?php echo "data-sitekey='$publickey'"; ?>></div>
            </div>

            <?php echo "$error"; ?>

            <div class="form-group">
              <button name="login" value="Login" class="btn btn-bold btn-block btn-primary" type="submit">Login</button>
            </div>
          </form>

          <hr class="w-30px">

          <p class="text-center text-muted fs-13 mt-20">Don't have an account? <a class="text-primary fw-500" href="#">Sign up</a></p>
        </div>
      </div>
    </div>




    <!-- Scripts -->
    <script src="../assets/js/core.min.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/js/script.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

  </body>
</html>
