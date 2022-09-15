<?php
require_once 'classes.php';
require_once 'dbcon.php';

$reg;

function SendBackWithError($message) {
	header("Location: ../pages/register.php?error=" . $message);
	die();
}
//If every variable is set, create new object
if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['passc']) && isset($_POST['email']) && isset($_POST['emailc']))
	$reg = new Signup(
		$_POST['username'], $_POST['pass'], $_POST['passc'],
		$_POST['email'], $_POST['emailc'], $con);
else {
	mysqli_close($con);
	SendBackWithError("Fields not filled");
}

//Attemps to register
try {
	//If error occurs doing query
	if (!$reg->Register()) {
		mysqli_close($con);
		SendBackWithError("Error during registration");
		die();
	}
} catch (Exception $e) {
	mysqli_close($con);
	SendBackWithError($e->getMessage());
	die();
}

//Fetches data for newly registered user
$res = mysqli_query(
	$con,
	"SELECT id, username, admin FROM Users WHERE username = '" . $reg->getUsername() . "' LIMIT 1"
);
mysqli_close($con);
$row = mysqli_fetch_assoc($res);
//Sets session cookies
$_SESSION['uid'] = $row['id'];
$_SESSION['username'] = $row['username'];
$_SESSION['admin'] = $row['admin'];
header("Location: ../pages/index.php");
?>