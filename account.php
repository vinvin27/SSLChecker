<?php
session_start();
include_once("config.php");
include_once("lib/functions.php");

  if (!isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
  header('Location: index.php');
  return;
}

  if(!isset($_SESSION['username']))  {
  header("Location: login.php");
  return;
}

if(!isset($_GET['pid'])) {
  header("Location: index.php");
}

$pid = $_GET['pid'];
  
  $error = "";

  if(isset($_POST['update'])) {

    $username = $_SESSION['username'];
    $password = $_POST['password'];
    $newpassword = $_POST['newpassword'];

    $account = new account();
    $account->db = $db;
    $result = $account->changePassword($password, $newpassword, $pid, $username);

    echo $result;

    if ($result == "success") {
      $error = "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <button type='button' class='close' data-dismiss='alert'><span>×</span></button>
              <strong>Congratulations!</strong><br> You successfully updated your password!
            </div>
      ";
    } else {
              $error = "
          <div class='alert alert-Danger alert-dismissible fade show' role='alert'>
            <button type='button' class='close' data-dismiss='alert'><span>×</span></button>
            <strong>Error!</strong><br> Something went wrong.
          </div>
        ";
    }

}
?>
<!DOCTYPE html>
<html>
  <?php
  include("header.php");
  ?>
    <main class="main-container">
      <div class="main-content">

        <div class="row">

          <div class="col-lg-6">
            <div class="card">
              <h4 class="card-title"><strong>Change password</strong></h4>
              <?php echo "$error"; ?>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <form class="form-type-material" role="form" <?php echo "action='account.php?pid=$pid'"; ?> method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password">
                        <label for="password">Password</label>
                      </div>                      
                      <div class="form-group">
                        <input type="password" class="form-control" name="newpassword" id="newpassword">
                        <label for="password">Confirm Password</label>
                      </div>

                      <div class="form-group">
                        <button name="update" value="update" class="btn btn-bold btn-block btn-primary" type="submit">Save</button>
                      </div>
                    </form>
                  </div>
                  </div>
                </div>
              </div>
            </div>

          <div class="col-lg-6">
          </div>
        </div>
      </div>

  <?php
  include("footer.php");
  ?>
</html>
