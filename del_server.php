<?php
	session_start();
	include_once("config.php");

		if(!isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
		header('Location: index.php');
		return;
	}

	if(!isset($_SESSION['username']))  {
		header("Location: login.php");
		return;
	}

	if(!isset($_GET['pid'])) {
		header("Location: admin.php");
	} else {
		$pid = $_GET['pid'];
		$sql = "DELETE FROM servers WHERE id=$pid;";
		$sql .= "DELETE FROM cert_history WHERE server_id=$pid;";
		echo "$sql";
		mysqli_multi_query($db, $sql);
		header("Location: index.php");
	}
?>