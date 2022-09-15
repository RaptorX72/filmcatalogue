<?php
include_once 'dbcon.php';

//If user is not logged in, return to index
if (!isset($_SESSION['uid'])) {
	header("Location: ../pages/index.php");
	die();
}

$id = $_POST['userid'];

//Runs query
global $con;
$res = mysqli_query(
	$con,
	"DELETE FROM History WHERE userid = " . $id . ";"
);
mysqli_close($con);

header("Location: ../pages/history.php");
?>