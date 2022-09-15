<?php
include_once 'dbcon.php';

function SendBack($error) {
	global $id;
	header("Location: ../pages/episodeform.php?fid=" . $id . "&error=" . $error);
	die();
}

function validateSeries($sid) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT * FROM Series WHERE id = " . $sid . ";"
	);
	return (mysqli_num_rows($res) != 0);
}

$id;
$seriesid;
$season;
if (isset($_POST['filmid'])) $id = $_POST['filmid'];

if (!isset($_POST['delete'])) {
	if (isset($_POST['seriesid'])) $seriesid = $_POST['seriesid'];
	if (isset($_POST['season'])) $season = $_POST['season'];
	//Checks if input data is valid
	if (
		$seriesid == "" ||
		$season == "" ||
		!is_numeric($seriesid) ||
		!is_numeric($season) ||
		!validateSeries($seriesid)
	) {
		//Return to episode's page
		SendBack("Input data is invalid");
	}
}

global $con;
$query;
//Sets query according to action
if (isset($_POST['delete'])) $query = "DELETE FROM Episodes WHERE filmid = " . $id . ";";
else {
	//Checks if film is in another series
	$res = mysqli_query(
		$con,
		"SELECT * FROM Episodes WHERE filmid = " . $id . " AND seriesid <> " . $seriesid . ";"
	);
	if (mysqli_num_rows($res) != 0) SendBack("Episode already present in another series");

	//Checks if film is new or edit
	$res = mysqli_query(
		$con,
		"SELECT * FROM Episodes WHERE filmid = " . $id . ";"
	);
	if (mysqli_num_rows($res) != 0) $query = "UPDATE Episodes SET seriesid = '" . $seriesid . "', season = " . $season . " WHERE filmid = " . $id . ";";
	else $query = "INSERT INTO Episodes (seriesid, filmid, season) VALUES (" . $seriesid . ", " . $id . ", " . $season . ");";
}
//Runs query
echo $query;
$res = mysqli_query($con, $query);
mysqli_close($con);

header("Location: ../pages/film.php?fid=" . $id);
?>