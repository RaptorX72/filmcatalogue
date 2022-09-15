<?php
$pagename = 'filmform';
include_once 'header.php';

//If user is not logged in or not admin, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) header("Location: index.php");

echo '<form action="../php/alterfilm.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">';
//If user wants to edit, get data for film
if (isset($_POST['filmid'])) {
	include_once '../php/dbcon.php';
	$res = mysqli_query(
		$con,
		"SELECT name, year, length, image FROM Films WHERE id = " . $_POST['filmid'] . ";"
	);
	mysqli_close($con);
	$row = mysqli_fetch_assoc($res);
	//Fill out form with existing data
	echo '<input type="text" name="filmid" value="' . $_POST['filmid'] . '" hidden />';
	echo '<span>Film name</span>';
	echo '<input type="text" name="name" value="' . $row['name'] . '" />';
	echo '<br />';
	echo '<span>Year</span>';
	echo '<input type="text" name="year" value="' . $row['year'] . '"/>';
	echo '<br />';
	echo '<span>Length</span>';
	echo '<input type="text" name="length" value="' . $row['length'] . '"/>';
	echo '<br />';
	echo '<input type="file" name="image" accept="image/png, image/jpeg" />';
	echo '<br />';
	if (!empty($row['image'])) echo '<img src="../resources/img/' . $row['image'] . '" />';
	else echo '<img src="../resources/img/nopicperson.png" />';
	echo '<input type="submit" name="Edit film"/>';
} else {
	//Prepare empty form
	echo '<span>Film name</span>';
	echo '<input type="text" name="name" value="" />';
	echo '<br />';
	echo '<span>Year</span>';
	echo '<input type="text" name="year" value=""/>';
	echo '<br />';
	echo '<span>Length</span>';
	echo '<input type="text" name="length" value=""/>';
	echo '<br />';
	echo '<input type="file" name="image" accept="image/png, image/jpeg" />';
	echo '<br />';
	echo '<input type="submit" name="Add film"/>';
}
echo '</form>';

include_once 'footer.php';
?>