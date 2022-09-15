<?php
$pagename = 'roleform';
include_once 'header.php';

//If user is not logged in or not admin, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) header("Location: index.php");

$filmid;
if (isset($_GET['fid'])) $filmid = $_GET['fid'];
else if (isset($_POST['filmid'])) $filmid = $_POST['filmid'];

echo '<form action="../php/alterrole.php" method="POST" accept-charset="utf-8">';
echo '<input type="text" name="filmid" value="' . $filmid . '" hidden />';
echo '<span>Role type</span>';
echo '<select name="roletype">';
echo '<option value="Plays">Actor</option><option value="Directing">Director</option><option value="Writing">Writer</option>';
echo '</select>';
echo '<input type="checkbox" name="star" /><span>Starring<sup>Only for Actor</sup></span>';
echo '<br />';
echo '<span>Person</span>';
//
echo '<select name="humanid">';
include_once '../php/dbcon.php';
$people = mysqli_query($con, "SELECT id, firstname, lastname FROM Humans");
mysqli_close($con);
while ($row = mysqli_fetch_assoc($people))
	echo '<option value="' . $row['id'] . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
echo '</select>';
//
echo '<br />';
echo '<input type="submit" name="Add role"/>';
echo '</form>';
echo '<a href="film.php?fid=' . $filmid . '">Go back</a>';
//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';

include_once 'footer.php';
?>