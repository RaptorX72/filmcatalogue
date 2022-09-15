<!DOCTYPE html>
<html lang="hu">
<head>
<title>2019_IB153l_Film</title>
<link rel="stylesheet" type="text/css" href="../css/header.css">
<?php
$styles = [
	'register' => ['register'],
	'login' => ['login'],
	'filmsearch' => ['filmsearch'],
	'seriessearch' => ['filmsearch'],
	'userform' => ['userform'],
	'seriesform' => ['seriesform']
];

if (isset($pagename)) {
	if (array_key_exists($pagename, $styles)) {
		foreach ($styles[$pagename] as $link) 
			echo '<link rel="stylesheet" type="text/css" href="../css/' . $link . '.css">';
	}
}
?>
</head>
<body>
<?php if (session_status() == 1) session_start(); ?>
<nav>
	<ul>
		<li><a href="index.php" title="">Home page</a></li>
		<li><a href="films.php" title="">Movies</a></li>
		<li><a href="series.php" title="">Series</a></li>
		<li><a href="people.php" title="">People</a></li>
		<?php
		//Check if user is logged in
		if (isset($_SESSION['uid'])) {
			//Display history
			echo '<li><a href="history.php" title="">History</a></li>';
			if ($_SESSION['admin']) echo '<li><a href="manageusers.php" title="">Manage users</a></li>';
			//Display edit account
			echo '<li><a href="userform.php" title="">Edit account</a></li>';
			//Display logout option
			echo '<li><a href="../php/logout.php" title="">Logout ' . $_SESSION['username'] . '</a></li>';
		} else echo '<li><a href="login.php" title="">Login</a></li>';
		?>
	</ul>
</nav>
<div id="separator"></div>
<hr />