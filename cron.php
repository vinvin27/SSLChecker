    <?php
    	include_once("config.php");
        include("lib/functions.php");

        $sqlget = "SELECT * FROM servers ORDER BY id";
        
        $res = mysqli_query($db, $sqlget) or die(mysqli_error());

        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {

                $getdata = new getData();

                $getdata->db = $db;
                $getdata->id = $row["id"];
                $getdata->url = $row["name"];
                $getdata->port = $row["port"];
                $getdata->old_valid_from = $row["valid_from"];
                $getdata->old_valid_to = $row["valid_to"];
                $getdata->old_authority = $row["authority"];

                $errstr = "";

                $getdata->getSSL();
			}
		}
?>