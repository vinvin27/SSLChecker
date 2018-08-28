<?php
session_start();

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


include_once("config.php");

$sql1 = "SELECT * FROM cert_history WHERE server_id=$pid ORDER BY event_id DESC";
$res1 = mysqli_query($db, $sql1) or die(mysqli_error());
$amount = mysqli_num_rows($res1);

$amount = $amount - 1;

$output = "";
$sql = "SELECT * FROM servers WHERE id=$pid";
$res = mysqli_query($db, $sql) or die(mysqli_error());

if(mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
      $id = $row["id"];
      $naam = $row["name"];
      $port = $row["port"];
      $authority_long = $row["authority"];
      $valid_from = $row["valid_from"];
      $valid_to = $row["valid_to"];
      $state = $row["state"];
  }
}

if ($state != 5) {
  $authority = mb_strimwidth($authority_long, 0, 45, "...");
} else {
  $authority = $authority_long;
}

if ($state == 3) {
  $state_show = "<td><span class='badge badge-pill badge-danger'>Expired</span></td>";
} elseif ($state == 2) {
  $state_show = "<td><span class='badge badge-pill badge-danger'>Almost expired</span></td>";
} elseif ($state == 1) {
  $state_show = "<td><span class='badge badge-pill badge-warning'>Renewable</span></td>";
} elseif ($state == 0) {
  $state_show = "<td><span class='badge badge-pill badge-success'>Good</span></td>";
} elseif ($state == 4) {
  $state_show = "<td><span class='badge badge-pill badge-info'>Polling</span></td>";
} elseif ($state == 5) {
  $state_show = "<td><span class='badge badge-pill badge-danger'>Error</span></td>";
} elseif ($state == 6) {
  $state_show = "<td><span class='badge badge-pill badge-danger'>Renewable</span></td>";
} elseif ($state == 7) {
  $state_show = "<td><span class='badge badge-pill badge-info'>Cloudflare</span></td>";
}

$authority_info = "<p title='$authority_long'>$authority</p>";
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
              <h4 class="card-title"><strong>SSL info</strong></h4>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                    <p><strong>Domain:</strong></p>
                    <p><strong>Port:</strong></p>
                    <p><strong>Authority:</strong></p>
                    <p><strong>Valid from:</strong></p>
                    <p><strong>Valid to:</strong></p>
                    <p><strong>State:</strong></p>
                  </div>
                  <div class="col-lg-9">
                    <p><?php echo "$naam";?></p>
                    <p><?php echo "$port";?></p>
                    <?php echo "$authority_info";?>
                    <p><?php echo "$valid_from";?></p>
                    <p><?php echo "$valid_to";?></p>
                    <p><?php echo "$state_show";?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card">
              <h4 class="card-title"><strong>Amount of old certificates</strong></h4>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 text-md-center">
                    <h2><?php echo "$amount";?> Certs</h2>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>


        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <h4 class="card-title"><strong>Certificate history</strong></h4>

              <div class="card-body">
<?php
    include_once("config.php");

    $countdown = "countdown";
    $output = "";

    $ip1 = $_SERVER['REMOTE_ADDR'];

    $pid = $_GET['pid'];

    $sql = "SELECT * FROM cert_history WHERE server_id=$pid ORDER BY event_id DESC";

    $res = mysqli_query($db, $sql) or die(mysqli_error());

    $posts1 = "
                <table class='table table-striped'>
                  <thead>
                <tr>
                  <th>Changed on</th>
                  <th>Certificate</th>
                  <th>Authority</th>
                  <th>Created on</th>
                  <th>Expird on</th>
                <tr>
              </thead>
              <tbody>
    ";

    echo $posts1;

    if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $event_date = $row["event_date"];
            $url = $row["url"];
            $authority = $row["authority"];
            $valid_from = $row["valid_from"];
            $valid_to = $row["valid_to"];

                  $posts =  "
                  <tr>
                    <td>$event_date</td>
                    <td>$url</td>
                    <td>$authority</td>
                    <td>$valid_from</td>
                    <td>$valid_to</td>
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
