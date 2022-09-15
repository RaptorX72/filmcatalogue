<?php
include_once 'dbcon.php';

function SendBack($error) {
	global $id;
	header("Location: ../pages/roleform.php?fid=" . $id . "&error=" . $error);
	die();
}

function validateHuman($hid) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT * FROM Humans WHERE id = " . $hid . ";"
	);
	return (mysqli_num_rows($res) != 0);
}

$id;
$humanid;
$type;
if (isset($_POST['filmid'])) $id = $_POST['filmid'];
if (isset($_POST['humanid'])) $humanid = $_POST['humanid'];
if (isset($_POST['roletype'])) $type = $_POST['roletype'];

$star;

if (!isset($_POST['delete'])) {
	if(isset($_POST['star'])) $star = 'true';
	else $star = 'false';
	//Checks if input data is valid
	if (!validateHuman($humanid)) {
		//Return to episode's page
		SendBack("Input data is invalid");
	}
}


global $con;
$query;
//Sets query according to action
if (isset($_POST['delete'])) $query = "DELETE FROM " . $type . " WHERE filmid = " . $id . ";";
else {
	//Checks if role in film and person already exists
	$asd = "SELECT * FROM " . $type . " WHERE filmid = " . $id . " AND humanid = " . $humanid . ";";
	$res = mysqli_query(
		$con,
		$asd
	);
	if (mysqli_num_rows($res) != 0) SendBack("Role already exists");
	echo $asd;
	if ($type == "Plays") $query = "INSERT INTO Plays (humanid, filmid, star) VALUES (" . $humanid . ", " . $id . ", " . $star . ");";
	else $query = "INSERT INTO " . $type . " (humanid, filmid) VALUES (" . $humanid . ", " . $id . ");";
}
//Runs query
echo $query;
$res = mysqli_query($con, $query);
mysqli_close($con);

header("Location: ../pages/film.php?fid=" . $id);
?>