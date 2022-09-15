<?php
$pagename = 'index';
include_once 'header.php';
if (isset($_SESSION['username'])) {
	echo '<h1>';
	echo 'Welcome to the front page ' . $_SESSION['username'] . '!';
	echo '</h1>';
}
include_once 'footer.php';
?>