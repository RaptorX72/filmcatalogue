<?php
$pagename = 'episodeform';
include_once 'header.php';

//If user is not logged in or not admin, return to index
if (!isset($_SESSION['uid']) || !$_SESSION['admin']) header("Location: index.php");

echo '<form action="../php/alterepisode.php" method="POST" accept-charset="utf-8">';
//If user wants to edit, get data for film
include_once '../php/dbcon.php';
$filmid;
if (isset($_GET['fid'])) $filmid = $_GET['fid'];
else if (isset($_POST['filmid'])) $filmid = $_POST['filmid'];

$res = mysqli_query(
	$con,
	"SELECT seriesid, filmid, season FROM Episodes WHERE filmid = " . $filmid . ";"
);

$series = mysqli_query($con, "SELECT id, name FROM Series");

function listOptions($id = null) {
	global $series;
	echo '<select name="seriesid">';
	while ($ro = mysqli_fetch_assoc($series)) {
		if ($id != null && $ro['id'] == $id) echo '<option value="' . $ro['id'] . '" selected>' . $ro['name'] . '</option>';
		else echo '<option value="' . $ro['id'] . '">' . $ro['name'] . '</option>';
	}
	echo '</select>';
}

mysqli_close($con);
if (mysqli_num_rows($res) != 0) {
	$row = mysqli_fetch_assoc($res);
	//Fill out form with existing data
	echo '<input type="text" name="filmid" value="' . $filmid . '" hidden />';
	echo '<span>Series</span>';
	listOptions($row['seriesid']);
	//echo '<input type="text" name="seriesid" value="' . $row['seriesid'] . '" />';
	echo '<br />';
	echo '<span>Season</span>';
	echo '<input type="text" name="season" value="' . $row['season'] . '"/>';
	echo '<br />';
	echo '<input type="submit" name="Edit episode"/>';
} else {
	//Prepare empty form
	echo '<input type="text" name="filmid" value="' . $filmid . '" hidden />';
	echo '<span>Series ID</span>';
	listOptions();
	//echo '<input type="text" name="seriesid" value="" />';
	echo '<br />';
	echo '<span>Season</span>';
	echo '<input type="text" name="season" value=""/>';
	echo '<br />';
	echo '<input type="submit" name="Add episode"/>';
}
echo '</form>';
echo '<a href="film.php?fid=' . $filmid . '">Go back</a>';
//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';

include_once 'footer.php';
?>