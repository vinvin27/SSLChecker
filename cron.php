    <?php
    	include_once("config.php");
        include("lib/functions.php");

        $sqlget = "SELECT * FROM servers ORDER BY id";
        
        $res = mysqli_query($db, $sqlget) or die(mysqli_error());

        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {

                $getdata = new getData();

                $getdata->useMail = $useMail;
                $getdata->usePush = $usePush;
                $getdata->testMail = $testMail;

                $getdata->mail_username = $mail_username;
                $getdata->mail_password = $mail_password;
                $getdata->mail_host = $mail_host;
                $getdata->mail_port = $mail_port;
                $getdata->mail_from = $mail_from;
                $getdata->mail_to = $mail_to;

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