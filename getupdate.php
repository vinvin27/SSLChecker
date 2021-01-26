<?php
  session_start();
  include_once("config.php");
  include("lib/functions.php");

  $admin = $_SESSION['admin'];

  if(!isset($_SESSION['admin']) || !isset($_SESSION['username'])) {
    $admin = 0;
  } else {
    $edit1 = "<th>".lang('STATUS_ADMIN_OPTIONS')."</th>";
  }

  $countdown = "countdown";
  $output = "";

  $ip1 = $_SERVER['REMOTE_ADDR'];

  $sql = "SELECT * FROM servers ORDER BY valid_to, name";

  $res = mysqli_query($db, $sql) or die(mysqli_error());
  $posts2 = '';
  $posts1 = "
          <table class='table table-striped'>
            <thead>
              <tr>
                <th>".lang('STATUS_DOMAIN')."</th>
                <th>".lang('STATUS_AUTH')."</th>
                <th>".lang('STATUS_PERIOD')."</th>
                <th>".lang('STATUS_EXPERY')."</th>
                <th>".lang('STATUS_STATE')."</th>
                $edit1
              <tr>
            </thead>
            <tbody>
  ";

  echo $posts1;




  if(mysqli_num_rows($res) > 0) {
      while($row = mysqli_fetch_assoc($res)) {

          $getupdate = new getUpdate();

          $getupdate->id = $row["id"];
          $getupdate->naam = $row["name"];
          $getupdate->authority_long = $row["authority"];
          $getupdate->valid_from = $row["valid_from"];
          $getupdate->valid_to = $row["valid_to"];
          $getupdate->state = $row["state"];
          $getupdate->admin = $admin;

          echo $getupdate->fetchData($posts1);

    }
  }
  $posts2 .= "
              </tbody>
            </table>
  ";
  echo $posts2;

  $getupdate = new getUpdate($db);
  $allDomains = $getupdate->getAllDomainsByAuthority('null');

  echo $getupdate->getRawData( $allDomains );

?>
<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm(<?php echo lang('STATUS_ADMIN_DELETE_MSG');?>)) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
</html>
