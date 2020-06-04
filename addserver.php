<?php
  session_start();
  include_once("config.php");

  $error = "";

    if (!isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('Location: index.php');
    return;
  }

    if(!isset($_SESSION['username']))  {
    header("Location: login.php");
    return;
  }

  if(isset($_POST['update'])) {
        $name = $_POST["name"];
        $port = $_POST["port"];

      if ($port == "") {
        $port = "443";
      }

    $sql = "INSERT INTO servers (name, port, authority, state) VALUES ('$name','$port','First update can take up to 24 hours.','4')";

        $sql1 = "SELECT * FROM servers WHERE name='$name'";
        $result = mysqli_query($db , $sql1);
        if($result->num_rows > 0){
          $error = "
                <div class='alert alert-Danger alert-dismissible fade show' role='alert'>
                  <button type='button' class='close' data-dismiss='alert'><span>×</span></button>
                  <strong>Error!</strong><br> Domain already exists.
                </div>
          ";      
        
        } else {

        if($name == "") {
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

  }
?>
  <?php
  include("header.php");
  ?>
    <main class="main-container">
      <div class="main-content">


        <div class="row justify-content-md-center">
          <div class="col-md-6 col-lg-4">
            <form class="card" action='addserver.php' method='post' enctype='multipart/form-data'>
            <div class="card">
              <h4 class="card-title"><strong>Add Server</strong></h4>
              <?php echo "$error"; ?>
                <div class="card-body">
                  <div class="form-group">
                    <input class="form-control" type="text" name='name' placeholder="https://example.com">
                  </div>

                  <div class="form-group">
                    <input class="form-control" type="text" name='port' placeholder="Default is 443">
                  </div>

                  <button name="update" type="submit" value="Update" class="btn btn-block btn-bold btn-primary">Submit</button>
                  </form>
                </div>
            </div>
          </div>
        </div>
      </div>

  <?php
  include("footer.php");
  ?>
</html>
