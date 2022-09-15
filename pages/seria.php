<?php
$pagename = 'seria';
include_once 'header.php';
include_once '../php/dbcon.php';
include_once '../php/echofunctions.php';

$seria = getOneSeries($_GET['sid']);
echoSeries($seria, true);

//If user is logged in and film page exists, allow user to post comments
if (isset($_SESSION['uid']) && $seria != null) {
	echo '<form action="commentform.php" method="POST" accept-charset="utf-8">';
	echo '<input type="text" name="tid" value="' . $seria->getID() . '" hidden />';
	echo '<input type="text" name="userid" value="' . $_SESSION['uid'] . '" hidden />';
	echo '<input type="text" name="type" value="series" hidden />';
	echo '<input type="submit" name="" value="New comment"/>';
	echo '</form>';
}
mysqli_close($con);

include_once 'footer.php';
?>