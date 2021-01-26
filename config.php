<?php
// Access settings are in .htaccess
// database logingegevens
$db_hostname = 'localhost';
$db_username = 'sslchecker';
$db_password = 'sslchecker';
$db_database = 'sslchecker';

// maak de database-verbinding
$db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

// Google Recaptcha Settings
$privatekey = "6Le8RzwaAAAAAMedWA5QTOhug7e78293iuAfHFbF";
$publickey = "6Le8RzwaAAAAAFYnSx6d_UDE-fgdv-JnBp1ouOjE";

// Pushbullet token (now in adminpanel)
$ajax102 = true;
$ajax101 = true;


// Notification Settings
$useMail = false;
$usePush = false;

$mail_username = "username";
$mail_password = "password";
$mail_host = "mail.example.com";
$mail_port = "587"; // Do not change (TLS Only)
$mail_from = "ssl@example.com";
$mail_to = "mymail@example.com";

include("lib/lang_en.php");

// Testing Settings
$testMail = false; // If true, SSLChecker will send mail for every entry in database. (I don't recommend adding more as 2 monitored certificates while testing.)
