<?php
include_once 'dbcon.php';
if (!isset($_SESSION['uid'])) {
	header("Location: ../pages/index.php");
	die();
}
$res = mysqli_query(
	$con,
	"INSERT INTO Rating (filmid, userid, rating) VALUES (" . $_POST['filmid'] . ", " . $_POST['userid'] . ", " . $_POST['rating'] . ");"
);
mysqli_close($con);
header("Location: ../pages/film.php?fid=" . $_POST['filmid']);
?>