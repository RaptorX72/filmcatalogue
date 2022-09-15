<?php
$username = $_POST['username'];
$password = $_POST['pass'];

//If username of password length is less, return false
function Validate($u, $p) {
	if (!empty($u) && !empty($p)) {
		return (strlen($u) >= 5 && strlen($p) >= 8);
	} else return false;
}

//Returns with error message paramater
function SendBackWithError($message) {
	header("Location: ../pages/login.php?error=" . $message);
	die();
}

if (Validate($username, $password)) {
	include_once 'dbcon.php';
	$res = mysqli_query(
		$con,
		"SELECT salt FROM Users WHERE username = '" . $username . "' LIMIT 1;"
	);
	//Checks if username exists in enty
	if (mysqli_num_rows($res) == 0) {
		mysqli_close($con);
		SendBackWithError("Username not found");
	}
	else {
		$row = mysqli_fetch_assoc($res);
		$res = mysqli_query(
			$con,
			"SELECT id, username, admin FROM Users WHERE username = '" . $username . "' AND password = SHA2(CONCAT('" . $row['salt'] . "','" . $password . "'),512) LIMIT 1;"
		);
		mysqli_close($con);
		//Checks if entry with hashed password and username combo exits
		if (mysqli_num_rows($res) == 0) SendBackWithError("Password incorrect");
		else {
			$row = mysqli_fetch_assoc($res);
			//Sets session cookies and returns to index
			$_SESSION['uid'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['admin'] = $row['admin'];
			header("Location: ../pages/index.php");
		}
	}
} else SendBackWithError("Username or password format incorrect");

?>