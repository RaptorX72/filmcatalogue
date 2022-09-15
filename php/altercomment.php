<?php
include_once 'dbcon.php';

$cid;
$userid;
$tid;
if (isset($_POST['cid'])) $cid = $_POST['cid'];
if (isset($_POST['userid'])) $userid = $_POST['userid'];
if (isset($_POST['tid'])) $tid = $_POST['tid'];

$type;
$posttext;

//If type is not available, return to avoid SQL error
if (!isset($_POST['type'])) {
	header("Location: ../pages/index.php");
	die();
}
else $type = $_POST['type'];

//If action is not delete, set data
if (!isset($_POST['delete'])) {
	if (!isset($_POST['posttext'])) {
		header("Location: ../pages/index.php");
		die();
	} else $posttext = $_POST['posttext'];
}

$query;
//Sets query according to action
if (isset($_POST['delete']))
	$query = "DELETE FROM " . ucfirst($type) . "Comments WHERE id = " . $cid . ";";
else if (isset($cid))
	$query = "UPDATE " . ucfirst($type) . "Comments SET posttext = '" . $posttext . "' WHERE id = " . $cid . ";";
else
	$query = "INSERT INTO " . ucfirst($type) . "Comments (userid, " . $type . "id, postdate, posttext) VALUES (" . $userid . ", " . $tid . ", NOW(), '" . $posttext . "');";

//Runs queries
global $con;

echo $query;

$returnid;
//If comment is either edited or deleted, return to film page
if (isset($_POST['cid'])) {
	$r = mysqli_query(
		$con,
		"SELECT " . $type . "id FROM " . ucfirst($type) . "Comments WHERE id = " . $cid . " LIMIT 1;"
	);
	$row = mysqli_fetch_assoc($r);
	$returnid = $row[$type . "id"];
}

$res = mysqli_query($con, $query);
mysqli_close($con);

$type;
if ($type == "film") $type = 'film.php?fid=';
else if ($type == "series") $type = 'seria.php?sid=';

if (isset($_POST['tid'])) header("Location: ../pages/" . $type . $tid);
else if (isset($_POST['cid'])) header("Location: ../pages/" . $type . $returnid);
else {
	if ($type == "film") header("Location: ../pages/films.php");
	else if ($type == "series") header("Location: ../pages/series.php");
}
?>