<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class general {

	public function getPID($username, $db) {

		$sql = "SELECT * FROM userlogin WHERE username='$username' LIMIT 1";
		$res = mysqli_query($db, $sql);

        if(mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            $id = $row["id"];
          }
        }

	return $id;

	}

	public function checkLicense(){
		//No touchy

	}

}


class getData {

	public $db = '';
	public $id = '';
	public $url = '';
	public $port = '';
	public $old_valid_from = '';
	public $old_valid_to = '';
	public $old_authority = '';
	public $mail_username = '';
	public $mail_password = '';
	public $mail_host = '';
	public $mail_port = '';
	public $mail_from = '';
	public $mail_to = '';
	public $useMail = '';
	public $usePush = '';


	public function getSSL(){

		$orignal_parse = parse_url($this->url, PHP_URL_HOST);
		$get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
		$read = stream_socket_client("ssl://".$orignal_parse.":$this->port", $errno, $errstr, 
		30, STREAM_CLIENT_CONNECT, $get);

		if($errstr !== '') {
			$this->serverError($errstr);
		} else {
			$this->calculateSSL($read);
		}

	}

	private function serverError($errstr){

		if (strpos($errstr,'No route to host') !== false) {
			$errormsg = "No route to host";
		} elseif (strpos($errstr,'Name or service') !== false) {
			$errormsg = "Hostname not found";
		} else {
			$errormsg = "Something went wrong";
		}
		echo "<br><br>**********************************************<br>";
		echo "$errstr<br><br>";
		mysqli_query($this->db, "UPDATE servers SET authority='$errormsg', state='5' WHERE id=$this->id");


		}

	private function calculateSSL($read){

		$cert = stream_context_get_params($read);
		$certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);

		$valid_from = date("Y-m-d",$certinfo['validFrom_time_t']);
		$valid_to = date("Y-m-d",$certinfo['validTo_time_t']);

		$CN1 = json_encode($certinfo['issuer']['CN']);
		$CN2 = (string)$CN1;

		$today = date("Y-m-d");
		$todayhour = date("Y-m-d h:i:sa");
		echo "$todayhour";

		$dStart = new DateTime($today);
		$dEnd  = new DateTime($valid_to);
		$dDiff = $dStart->diff($dEnd);

		$auth6 = addslashes($CN2);
		$auth6 = preg_replace("/[^a-zA-Z0-9\s]/", "", $auth6);

		if ($dDiff->days < 1) {
			$state = "3";
		} elseif ($dDiff->days < 11) {
			$state = "2";
		} elseif ($dDiff->days < 21) {
			$state = "6";
		} elseif ($dDiff->days < 31) {
			$state = "1";
		} elseif ($dDiff->days < 61 && $auth6 != "Lets Encrypt Authority X3") {
			$state = "1";
		} else {
			$state = "0";
		}

		if ($auth6 == "COMODO ECC Domain Validation Secure Server CA 2") {
			$auth6 = "Managed by CloudFlare";
			$state = "7";
		}

		if ($valid_to != $this->old_valid_to && $auth6 != "Managed by CloudFlare") {
			mysqli_query($this->db, "INSERT INTO cert_history (event_id, event_date, server_id, authority, valid_from, valid_to, url) VALUES ('','$today','$this->id','$this->old_authority','$this->old_valid_from', '$this->old_valid_to', '$this->url')");
		}

		echo "<br><br>";

		$debug = 'false';

		if ($debug == "true") {
			echo "Server: $this->url<br>";
			echo "Days left: $dDiff->days<br>";
			echo "Valid from: $valid_from<br>";
			echo "Valid to: $valid_to<br>";
			echo "Error: $errstr<br>";
			echo "============";
			echo "<br>";
		}

		$this->sendNotification($dDiff, $auth6);

		mysqli_query($this->db, "UPDATE servers SET valid_from='$valid_from', valid_to='$valid_to', state='$state', authority='$auth6' WHERE id=$this->id");
		if ($debug != "true") {
		    header('Location: index.php');
		}
	}

	private function sendNotification($dDiff, $auth6){

		if ($dDiff->days == 30 && $auth6 != "Lets Encrypt Authority X3") {

			$trigger = true;
			$nmessage = "The certificate $this->url from $auth6 is about to expire. You have 30 days left before expiration.";

		} elseif ($dDiff->days == 20) {

			$trigger = true;
			$nmessage = "The certificate $this->url from $auth6 is about to expire. You have 20 days left before expiration.";

		} elseif ($dDiff->days == 10) {

			$trigger = true;
			$nmessage = "The certificate $this->url from $auth6 is about to expire. You have 10 days left before expiration.";

		} elseif ($dDiff->days == 1) {

			$trigger = true;
			$nmessage = "The certificate $this->url from $auth6 is about to expire. You have 1 day left before expiration.";
		}

		if ($this->useMail == true && $trigger == true) {
			$this->sendMail($nmessage);
		}
		if ($this->usePush == true && $trigger == true) {
			$this->sendPush($nmessage);
		}
	}

	private function sendPush($nmessage){

		include_once("pushbullet.php");

	    $sql = "SELECT * FROM pushbullet ORDER BY id DESC";

	    $res = mysqli_query($this->db, $sql) or die(mysqli_error());

	    if(mysqli_num_rows($res) > 0) {
	        while($row = mysqli_fetch_assoc($res)) {
	            $name = $row["name"];
	            $token = $row["token"];

				$target = "";
				$body = "$nmessage";

				$pb = new Pushbullet($token);
				$pb->pushNote($target, $title, $body);

	        }
	    }

	}

	private function sendMail($nmessage){

		include 'template.php';
		require_once 'Exception.php';
		require_once 'PHPMailer.php';
		require_once 'SMTP.php';

		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
		    //Server settings
		    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = "$this->mail_host";  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = "$this->mail_username";                 // SMTP username
		    $mail->Password = "$this->mail_password";                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = $this->mail_port;                                    // TCP port to connect to

		    //Recipients
		    $mail->setFrom("$this->mail_from", 'SSLChecker');
		    $mail->addAddress("$this->mail_to");

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = "$this->url needs your attention";
		    $mail->Body    = "$email_3 $nmessage $email_4";

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}
}

class getUpdate {

	public $id = '';
	public $naam = '';
	public $authority_long = '';
	public $valid_from = '';
	public $valid_to = '';
	public $state = '';
	public $admin = '';

	public function fetchData(){
        if ($this->state != 5) {
          $authority = mb_strimwidth($this->authority_long, 0, 25, "...");
        } else {
          $authority = $this->authority_long;
        }

          if ($this->authority_long == "null" && $this->state != 5){
            $authority = "Certificate is invalid!";
            $this->state = "3";
          } elseif ($this->authority_long == "null" && $this->state = 5){
            $authority = "Couldn't fetch any SSL data";
            $state_show = "<td><span class='badge badge-pill badge-danger'>Error</span></td>";
          }

          $color = "";

          if ($this->state == 3) {
            $state_show = "<td><span class='badge badge-pill badge-danger'>Expired</span></td>";
            $color = "class='bg-dark'";
          } elseif ($this->state == 2) {
            $state_show = "<td><span class='badge badge-pill badge-danger'>Almost expired</span></td>";
          } elseif ($this->state == 6) {
            $state_show = "<td><span class='badge badge-pill badge-danger'>Renewable</span></td>";
          } elseif ($this->state == 1) {
            $state_show = "<td><span class='badge badge-pill badge-warning'>Renewable</span></td>";
          } elseif ($this->state == 0) {
            $state_show = "<td><span class='badge badge-pill badge-success'>Good</span></td>";
          } elseif ($this->state == 4) {
            $state_show = "<td><span class='badge badge-pill badge-info'>Polling</span></td>";
          } elseif ($this->state == 5) {
            $state_show = "<td><span class='badge badge-pill badge-danger'>Error</span></td>";
            $color = "class='bg-dark'";
          } elseif ($this->state == 7) {
            $state_show = "<td><span class='badge badge-pill badge-info'>CloudFlare</span></td>";
          }

          if ($this->admin != 0) {
            $edit2 = "<td><a href='server_log.php?pid=$this->id' title='Show history'><i class='fa fa-fw fa-history'></i></a><a href='del_server.php?pid=$this->id' title='Delete server' class='confirmation'><i class='fa fa-fw fa-close'></i></a></td>";
          }

          $search = 'https://' ;
          $this->naam = str_replace($search, '', $this->naam) ;

              $posts =  "
              <tr $color>
                <td>$this->naam</td>
                <td>$authority</td>
                <td>$this->valid_from</td>
                <td>$this->valid_to</td>
                $state_show
                $edit2
              </tr>";
              return $posts;
	}

}

class account{

	public $db = '';

	public function changePassword($password, $newpassword, $pid, $username){

		$valid = $this->verifyPID($pid, $username);
		$check = $this->passwordCheck($password, $newpassword);

		if ($valid == true && $check == true) {
			$this->passwordUpdate($password, $newpassword, $pid);
			$result = "success";
		} else {
			$result = "failed";
		}

		return $result;

	}

	private function verifyPID($pid, $username) {

		$sql = "SELECT * FROM userlogin WHERE id=$pid LIMIT 1";
		$res = mysqli_query($this->db, $sql);

        if(mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            $username_db = $row["username"];

           if ($username_db == $username) {
           	$result = true;
           } else {
           	$result = false;
           }
          }
        }

	return $result;

	}

	private function passwordCheck($password, $newpassword) {

		if ($password == $newpassword && $password != "" && $newpassword != "") {
			$result = true;
		} else {
			$result = false;
		}

	return $result;

	}

	private function passwordUpdate($password, $newpassword, $pid) {

	    $password = strip_tags($password);
	    $newpassword = strip_tags($newpassword);
		$password = stripslashes($password);
		$newpassword = stripslashes($newpassword);
		$password = mysqli_real_escape_string($this->db, $password);
		$newpassword = mysqli_real_escape_string($this->db, $newpassword);
		$password = md5($password);
		$newpassword = md5($newpassword);

		$sql = "UPDATE userlogin SET password='$password' WHERE id=$pid";

		mysqli_query($this->db, $sql);
	}
}

?>
