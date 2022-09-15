<?php
$pagename = 'manageusers';
include_once 'header.php';
include_once '../php/echofunctions.php';
include_once '../php/dbcon.php';

//If user is neither admin or logged in, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) {
	header("Location: index.php");
	die();
}

//Lists all available users
$users = getUsers();
foreach ($users as $u) echoUserList($u);

include_once 'footer.php';
?>