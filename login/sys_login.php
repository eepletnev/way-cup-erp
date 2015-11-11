<?php

require_once('../sys/sys_db_connect.php');
require_once('../sys/sys_functions.php');
wcp_session_start();

if (isset($_POST['username'], $_POST['p'])) {
	$username = $_POST['username'];
	$password = $_POST['p'];

	$check = login($username, $password, $mysqli);

	if ($check == 1) { 
		// Loggin success
		header('Location: ../erp/');
	} else {
		// Fayuol
		header('Location: login.php?error=' . $check);
	}
} else {
	echo 'Something went terribly wrong.';
}
?>