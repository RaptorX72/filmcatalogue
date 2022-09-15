<?php
$pagename = 'commentform';
include_once 'header.php';

//If user is not logged in return to index
if (!isset($_SESSION['uid'])) header("Location: index.php");
if (!isset($_POST['type'])) header("Location: index.php");
if (isset($_POST['userid']))
	//If user attempts to edit someone else's comment, return to index
	if ($_POST['userid'] != $_SESSION['uid']) header("Location: index.php");

echo '<form action="../php/altercomment.php" method="POST" accept-charset="utf-8">';
//If user wants to edit their own post, get the text data
if (isset($_POST['cid'])) {
	include_once '../php/dbcon.php';
	$res = mysqli_query(
		$con,
		"SELECT posttext FROM " . ucfirst($_POST['type']) . "Comments WHERE id = " . $_POST['cid'] . ";"
	);
	mysqli_close($con);
	$row = mysqli_fetch_assoc($res);
	//Fill out form
	echo '<input type="text" name="type" value="' . $_POST['type'] . '" hidden />';
	echo '<input type="text" name="cid" value="' . $_POST['cid'] . '" hidden />';
	echo '<span>Comment</span>';
	echo '<input type="text" name="posttext" value="' . $row['posttext'] . '" />';
	echo '<br />';
	echo '<input type="submit" name="Edit comment"/>';
} else {
	//Prepar blank form to post
	echo '<input type="text" name="type" value="' . $_POST['type'] . '" hidden />';
	echo '<input type="text" name="userid" value="' . $_POST['userid'] . '" hidden />';
	echo '<input type="text" name="tid" value="' . $_POST['tid'] . '" hidden />';
	echo '<span>Comment</span>';
	echo '<input type="text" name="posttext" value="" />';
	echo '<br />';
	echo '<input type="submit" name="Post comment"/>';
}
echo '</form>';

include_once 'footer.php';
?>