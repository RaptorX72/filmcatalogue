<?php
$pagename = 'userform';
include_once 'header.php';
//If user is not logged in, return to index
if (!isset($_SESSION['uid']) ) {
	header("Location: index.php");
	die();
}

echo '<form class="form" action="../php/alteruser.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">';
include_once '../php/dbcon.php';
$res = mysqli_query(
	$con,
	"SELECT username, email, image FROM Users WHERE id = " . $_SESSION['uid'] . ";"
);
mysqli_close($con);
$row = mysqli_fetch_assoc($res);

//Fill out form with existing data
echo '<input class="input" type="text" name="image" value="null" hidden />';
echo '<span class="text">Username</span>';
echo '<input class="input" type="text" name="username" value="' . $row['username'] . '" />';
echo '<br />';
echo '<span class="text">email</span>';
echo '<input class="input" type="text" name="email" value="' . $row['email'] . '"/>';
echo '<br />';
echo '<fieldset>';
	echo '<legend>Edit password</legend>';
	echo '<spanclass="text" >New password</span>';
	echo '<input class="input" type="password" name="newpass" value=""/>';
	echo '<br />';
	echo '<span class="text">New password confirm</span>';
	echo '<input class="input" type="password" name="newpassc" value=""/>';
	echo '<br />';
	echo '<hr />';
	echo '<span class="text">Old password</span>';
	echo '<input class="input" type="password" name="cpass" value=""/>';
	echo '<br />';
echo '</fieldset>';
echo '<input type="file" name="image" accept="image/png, image/jpeg" />';
echo '<br />';
if (!empty($row['image'])) echo '<img src="../resources/img/' . $row['image'] . '" />';
else echo '<img src="../resources/img/nopicperson.png" />';
echo '<input class="button" type="submit" name="Edit film"/>';
echo '</form>';

//Delete form
for ($i = 0; $i < 5; $i++) echo '<br />';
echo '<form action="../php/alteruser.php" method="POST" accept-charset="utf-8">';
echo '<input type="text" name="userid" value="' . $_SESSION['uid'] . '" hidden />';
echo '<input type="text" name="delete" value="true" hidden />';
echo '<input class="button2" type="submit" name="delete" value="Delete account"/>';
echo '</form>';

//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';

include_once 'footer.php';
?>