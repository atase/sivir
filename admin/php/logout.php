<?php 
	session_start();
	$_SESSION['token'] = "none";
	session_destroy();
	header('Location: ../../admin/index.php');
?>