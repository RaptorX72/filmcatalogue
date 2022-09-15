<?php
$pagename = 'film';
include_once 'header.php';
include_once '../php/dbcon.php';
include_once '../php/echofunctions.php';

//History saving process
if (isset($_SESSION['uid'])) {
	$r = mysqli_query(
		$con,
		"SELECT userid, filmid FROM History WHERE userid = " . $_SESSION['uid'] . " AND filmid = " . $_GET['fid'] . ";"
	);
	//If film exists in history, delete from database
	if (mysqli_num_rows($r) != 0) {
		$r = mysqli_query(
			$con,
			"DELETE FROM History WHERE userid = " . $_SESSION['uid'] . " AND filmid = " . $_GET['fid'] . ";"
		);
	}
	//Insert film to history database
	$r = mysqli_query(
		$con,
		"INSERT INTO History (userid, filmid) VALUES (" . $_SESSION['uid'] . ", " . $_GET['fid'] . ");"
	);
}

$film = getFilm($_GET['fid']);
echoFilm($film, true);

//If user is logged in and film page exists, allow user to post comments
if (isset($_SESSION['uid']) && $film != null) {
	echo '<form action="commentform.php" method="POST" accept-charset="utf-8">';
	echo '<input type="text" name="tid" value="' . $film->getID() . '" hidden />';
	echo '<input type="text" name="userid" value="' . $_SESSION['uid'] . '" hidden />';
	echo '<input type="text" name="type" value="film" hidden />';
	echo '<input type="submit" name="" value="New comment"/>';
	echo '</form>';
}

mysqli_close($con);

include_once 'footer.php';
?>