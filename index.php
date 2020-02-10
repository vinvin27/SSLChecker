<?php
  session_start();
  include_once("config.php");

  $username = $_SESSION['username'];

  if($username == "") {
      $username = "Guest";
  }
?>
	<?php
	include("header.php");
	?>
    <main class="main-container">
      <div class="main-content">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <h4 class="card-title"><strong><?php echo lang('STATUS_MONITOR');?></strong></h4>
              <div class="card-body">
                  <div id="statusElement1"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
	<?php
	include("footer.php");
	?>
</html>
