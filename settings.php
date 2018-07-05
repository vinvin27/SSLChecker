<?php
session_start();
include_once("config.php");

  if (!isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
  header('Location: index.php');
  return;
}

  if (isset($_SESSION['admin'])) {
    $x_level = "2";
  }

  if(!isset($_SESSION['username']))  {
  header("Location: login.php");
  return;
}

  if(isset($_POST['update'])) {
        $name = $_POST["name"];
        $token = $_POST["token"];

      if ($name == "") {
        $name = "Unknown";
      }

    $sql = "INSERT INTO pushbullet (id, name, token) VALUES ('','$name','$token')";

        if($token == "") {
          $error = "
                <div class='alert alert-Danger alert-dismissible fade show' role='alert'>
                  <button type='button' class='close' data-dismiss='alert'><span>×</span></button>
                  <strong>Error!</strong><br> Please complete the fields.
                </div>
          ";
        } else {
          mysqli_query($db, $sql);
          $error = "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <button type='button' class='close' data-dismiss='alert'><span>×</span></button>
                  <strong>Congratulations!</strong><br> You successfully submitted your request. We'll process it soon.
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
            <form class="card" action='settings.php' method='post' enctype='multipart/form-data'>
            <div class="card">
              <h4 class="card-title"><strong>Add Token</strong></h4>
              <?php echo "$error"; ?>
                <div class="card-body">
                  <div class="form-group">
                    <input class="form-control" type="text" name='name' placeholder="Comment">
                  </div>

                  <div class="form-group">
                    <input class="form-control" type="text" name='token' placeholder="Token">
                  </div>

                  <button name="update" type="submit" value="Update" class="btn btn-block btn-bold btn-primary">Submit</button>
                  </form>
                </div>
            </div>
          </div>

          <div class="col-lg-6">
          </div>

        </div>


        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <h4 class="card-title"><strong>Pushbullet Tokens</strong></h4>

              <div class="card-body">
<?php
    include_once("config.php");

    $countdown = "countdown";
    $output = "";

    $ip1 = $_SERVER['REMOTE_ADDR'];

    $sql = "SELECT * FROM pushbullet ORDER BY id DESC";

    $res = mysqli_query($db, $sql) or die(mysqli_error());

    $posts1 = "
                <table class='table table-striped'>
                  <thead>
                <tr>
                  <th>ID</th>
                  <th>Comment</th>
                  <th>Token</th>
                <tr>
              </thead>
              <tbody>
    ";

    echo $posts1;

    if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $id = $row["id"];
            $name = $row["name"];
            $token = $row["token"];

                  $posts =  "
                  <tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$token</td>
                  </tr>";
                  echo $posts;
            }
            
   }
    $posts2 .= "
                </tbody>
              </table>
    ";
    echo $posts2;
?>
              </div>
            </div>
          </div>
        </div>
      </div>

  <?php
  include("footer.php");
  ?>
</html>
