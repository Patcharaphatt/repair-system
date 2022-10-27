<?php
session_start();
if(!isset($_SESSION['login'])) {
	header("location: /repair-system/auth/index.php");
	exit;
}

?>