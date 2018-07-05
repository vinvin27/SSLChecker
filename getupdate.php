<?php
  session_start();

  $admin = $_SESSION['admin'];

  if(!isset($_SESSION['admin']) || !isset($_SESSION['username'])) {
    $admin = 0;
  } else {
    $edit1 = "<th>Options</th>";
  }

?>

<?php
    include_once("config.php");
    include("lib/functions.php");

    $countdown = "countdown";
    $output = "";

    $ip1 = $_SERVER['REMOTE_ADDR'];

    $sql = "SELECT * FROM servers ORDER BY valid_to, name";

    $res = mysqli_query($db, $sql) or die(mysqli_error());

    $posts1 = "
            $ajax102
            <table class='table table-striped'>
              <thead>
                <tr>
                  <th>Domain</th>
                  <th>Authority</th>
                  <th>Created</th>
                  <th>Expiry</th>
                  <th>State</th>
                  $edit1
                <tr>
              </thead>
              <tbody>
    ";

    echo $posts1;

    if($ajax101 == "false") {
      echo "
                  <tr class='bg-dark'>
                    <td>INVALID</td>
                    <td>LICENSE</td>
                    <td>INVALID</td>
                    <td>LICENSE</td>
                    <td><span class='badge badge-pill badge-danger'>Error</span></td>
                  </tr>";
      exit();
    }


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

            echo $getupdate->fetchData($posts);
            
   }
  }
    $posts2 .= "
                </tbody>
              </table>
    ";
    echo $posts2;
?>
<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this entry from the database?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
</html>
