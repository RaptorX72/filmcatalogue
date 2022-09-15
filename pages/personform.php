<?php
$pagename = 'personform';
include_once 'header.php';

//If user is not logged in or not admin, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) header("Location: index.php");

echo '<form action="../php/alterperson.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">';
//If user wants to edit, get data for film
if (isset($_POST['pid'])) {
	include_once '../php/dbcon.php';
	$res = mysqli_query(
		$con,
		"SELECT firstname, lastname, birthdate, image FROM Humans WHERE id = " . $_POST['pid'] . ";"
	);
	mysqli_close($con);
	$row = mysqli_fetch_assoc($res);
	//Fill out form with existing data
	echo '<input type="text" name="pid" value="' . $_POST['pid'] . '" hidden />';
	echo '<span>Firstname</span>';
	echo '<input type="text" name="firstname" value="' . $row['firstname'] . '" />';
	echo '<br />';
	echo '<span>Lastname</span>';
	echo '<input type="text" name="lastname" value="' . $row['lastname'] . '"/>';
	echo '<br />';
	echo '<span>Birthdate</span>';
	echo '<input type="text" name="birthdate" value="' . $row['birthdate'] . '"/>';
	echo '<br />';
	echo '<input type="file" name="image" accept="image/png, image/jpeg" />';
	echo '<br />';
	if (!empty($row['image'])) echo '<img src="../resources/img/' . $row['image'] . '" />';
	else echo '<img src="../resources/img/nopicperson.png" />';
	echo '<input type="submit" name="Edit person"/>';
} else {
	//Prepare empty form
	echo '<span>Firstname</span>';
	echo '<input type="text" name="firstname" value="" />';
	echo '<br />';
	echo '<span>Lastname</span>';
	echo '<input type="text" name="lastname" value=""/>';
	echo '<br />';
	echo '<span>Birthdate</span>';
	echo '<input type="text" name="birthdate" value=""/>';
	echo '<br />';
	echo '<input type="file" name="image" accept="image/png, image/jpeg" />';
	echo '<br />';
	echo '<input type="submit" name="Add person"/>';
}
echo '</form>';

include_once 'footer.php';
?>