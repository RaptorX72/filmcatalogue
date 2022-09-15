<?php
include_once 'dbcon.php';
include_once 'imagehandler.php';

if (!isset($_SESSION['uid'])) header("Location: ../pages/index.php");

function SendBackWithError($message) {
	echo $message;
	header("Location: ../pages/userform.php?error=" . $message);
	die();
}

$id;
if (isset($_POST['userid'])) $id = $_POST['userid'];

$cpass;
$np;
$npc;
//If password change is attempted
if (isset($_POST['cpass']) && $_POST['cpass'] != null) {
	$cpass = $_POST['cpass'];//Current password
	$np = $_POST['newpass'];
	$npc = $_POST['newpassc'];//New password confirm
	//Checks if new password and confirm is either empty or don't match
	if (strlen($np) == 0 || strlen($npc) == 0 || strlen($cpass) == 0)
		SendBackWithError("Password can't be empty");
	if (strlen($np) < 8 || strlen($npc) < 8 || strlen($cpass) < 8)
		SendBackWithError("Password length too small");
	if ($np !== $npc)
		SendBackWithError("New passwords dont match");
	//Gets the user's salt
	$res = mysqli_query(
		$con,
		"SELECT salt FROM Users WHERE id = '" . $_SESSION['uid'] . "' LIMIT 1;"
	);
	$row = mysqli_fetch_assoc($res);
	$salt = $row['salt'];
	//Checks with salt if the old passwords match
	$res = mysqli_query(
		$con,
		"SELECT id FROM Users WHERE id = " . $_SESSION['uid'] . " AND password = SHA2(CONCAT('" . $salt . "','" . $cpass . "'),512) LIMIT 1;"
	);
	if (mysqli_num_rows($res) == 0)
		SendBackWithError("Old password doesnt match");
	//Updates new password
	$res = mysqli_query(
		$con,
		"UPDATE Users SET password = SHA2(CONCAT('" . $salt . "','" . $np . "'),512) WHERE id = " . $_SESSION['uid'] . ";"
	);
}

$username;
$email;

if(!isset($_POST['delete'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	//Checks if other fields are empty
	if (strlen($username) < 5 || strlen($email) < 5)
		SendBackWithError("Fields can't be empty");
	//Checks if username is in use
	$res = mysqli_query(
			$con,
			"SELECT id FROM Users WHERE username = '" . $username . "' AND id <> " . $_SESSION['uid'] . " LIMIT 1;"
	);
	if (mysqli_num_rows($res) > 0)
		SendBackWithError("Username already in use");
	//Checks if email is in use
	$res = mysqli_query(
			$con,
			"SELECT id FROM Users WHERE email = '" . $email . "' AND id <> " . $_SESSION['uid'] . " LIMIT 1;"
	);
	if (mysqli_num_rows($res) > 0)
		SendBackWithError("Email already in use");
}


$query;
$queries = array();
//Set query according to action
if (isset($_POST['delete'])) {
	array_push($queries, "DELETE FROM History WHERE userid = " . $id . ";");
	array_push($queries, "DELETE FROM SeriesComments WHERE userid = " . $id . ";");
	array_push($queries, "DELETE FROM FilmComments WHERE userid = " . $id . ";");
	array_push($queries, "DELETE FROM Rating WHERE userid = " . $id . ";");
	array_push($queries, "DELETE FROM Users WHERE id = " . $id . ";");
} else {
	if(isset($_FILES['image'])) {
		$query = "UPDATE Users SET username = '" . $username . "', email = '" . $email . "'";
		if (deleteImage($id, 'Users')) {
			$img = uploadImage($_FILES['image']);
			if ($img->getResult()) $query .= ", image = '" . $img->getImageName() . "'";
		}
	}
	$query .= " WHERE id = " . $_SESSION['uid'];
}
//Runs query
global $con;
if (isset($_POST['delete'])) {
	deleteImage($id, 'Users');
	foreach ($queries as $q) $res = mysqli_query($con, $q);
} else {
	$res = mysqli_query($con, $query);
	$_SESSION['username'] = $username;
}
mysqli_close($con);

if (isset($_POST['delete'])) {
	if ($_POST['userid'] == $_SESSION['uid']) {
		header("Location: logout.php");
		die();
	}
	header("Location: ../pages/manageusers.php");
	die();
}

header("Location: ../pages/userform.php");
?>