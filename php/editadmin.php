<?php
include_once 'dbcon.php';

//If user is not admin or logged in, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) {
	header("Location: ../pages/index.php");
	die();
}

$id = $_POST['userid'];
$admin = $_POST['adminstatus'];

//Flips boolean
if ($admin == 0) $admin = 1;
else if ($admin == 1) $admin = 0;

$query = "UPDATE Users SET admin = " . $admin . " WHERE id = " . $id . ";";

//Runs query
global $con;
$res = mysqli_query($con, $query);
mysqli_close($con);

header("Location: ../pages/manageusers.php");
?>