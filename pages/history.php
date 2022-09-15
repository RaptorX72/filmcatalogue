<?php
$pagename = 'history';
include_once 'header.php';
include_once '../php/dbcon.php';
include_once '../php/echofunctions.php';

if (!isset($_SESSION['uid'])) {
	header("Location: index.php");
	die();
}

//Select every film in history linked to user
$res = mysqli_query(
	$con,
	"SELECT filmid FROM History WHERE userid = " . $_SESSION['uid'] . ";"
);

$films = array();
//If history is not empty, push film object to array
if (mysqli_num_rows($res) != 0) {
	while ($row = mysqli_fetch_assoc($res)) {
		$film = getFilm($row['filmid']);
		array_push($films, $film);
	}
	$films = array_reverse($films);
} else echo '<p>No history</p>';

foreach ($films as $film) echoFilmList($film);

//If user is logged in and film history exists, allow user to clear
if (isset($_SESSION['uid']) && $films != null) {
	echo '<form action="../php/clearhistory.php" method="POST" accept-charset="utf-8">';
	echo '<input type="text" name="userid" value="' . $_SESSION['uid'] . '" hidden />';
	echo '<input type="submit" name="" value="Clear history"/>';
	echo '</form>';
}
mysqli_close($con);

include_once 'footer.php';
?>