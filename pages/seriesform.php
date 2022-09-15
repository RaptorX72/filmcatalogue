<?php
$pagename = 'seriesform';
include_once 'header.php';
//If user is not logged in or not admin, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) header("Location: index.php");
echo '<br />';
echo '<br />';
echo '<br />';
echo '<form action="../php/alterseries.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">';
//If user wants to edit, get data for film
if (isset($_POST['seriesid'])) {
	include_once '../php/dbcon.php';
	$res = mysqli_query(
		$con,
		"SELECT name, image FROM Series WHERE id = " . $_POST['seriesid'] . ";"
	);
	mysqli_close($con);
	$row = mysqli_fetch_assoc($res);
	//Fill out form with existing data
	echo '<input class="input" type="text" name="seriesid" value="' . $_POST['seriesid'] . '" hidden />';
	echo '<span class="text">Series name</span>';
	echo '<input class="input" type="text" name="name" value="' . $row['name'] . '" />';
	echo '<br />';
	echo '<input class="input" type="file" name="image" accept="image/png, image/jpeg" />';
	echo '<br />';
	if (!empty($row['image'])) echo '<img src="../resources/img/' . $row['image'] . '" />';
	else echo '<img src="../resources/img/nopicperson.png" />';
	echo '<input class="button" type="submit" name="Edit series"/>';
} else {
	//Prepare empty form
	echo '<span>Series name</span>';
	echo '<input type="text" name="name" value="" />';
	echo '<br />';
	echo '<input type="file" name="image" accept="image/png, image/jpeg" />';
	echo '<br />';
	echo '<input type="submit" name="Add series"/>';
}
echo '</form>';

include_once 'footer.php';
?>