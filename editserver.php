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

    $sql = "INSERT INTO servers (id, name, port, authority, state) VALUES ('','$name','$port','First update can take up to 24 hours.','4')";

        if($name == "") {
            $error = "Please complete the field!";
            $errorcolor = "red";
        } else {
          mysqli_query($db, $sql);
          $error = "Added ($name) in the Database. First update can take up to 24 hours.";
          $errorcolor = "green";
        }

  }
?>
  <?php
  include("header.php");
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Domain
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Login</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <br><br><br><br>
      </div>
      <div class="row">
        <!-- left column -->
        <div class="col-md-4">
        </DIV>
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Domain</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<?php echo "$error"; ?>
            </div>
              <div class="box-body">

                  <form action='addserver.php' method='post' enctype='multipart/form-data'>

                    <div class='form-group'>
                    <label for='hostname'>Domain</label>
                    <input type='hostname' class='form-control' name='name' value='' placeholder='https://vboxxcloud.nl'>
                    </div>

                    <div class='form-group'>
                    <label for='port'>Custom port</label>
                    <input type='port' class='form-control' name='port' value='' placeholder='Default is 443'>
                    </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button name="update" type="submit" value="Update" class="btn btn-primary">Add</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
	<?php
	include("footer.php");
	?>
</html>
