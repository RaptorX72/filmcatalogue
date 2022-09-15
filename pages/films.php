<?php
$pagename = 'films';
include_once 'header.php';
include_once '../php/dbcon.php';
include_once '../php/echofunctions.php';

$query;
$search;
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$type = $_GET['criteria'];

	switch ($type) {
		case 'name':
			$query = "SELECT id, name, year, length, image FROM Films WHERE id NOT IN (SELECT filmid FROM Episodes) AND name LIKE '%" . $search . "%';";
			break;
		case 'year':
			if (!is_numeric($search)) {
				header("Location: filmsearch.php?error=Year not in number format");
				die();
			}
			$query = "SELECT id, name, year, length, image FROM Films WHERE id NOT IN (SELECT filmid FROM Episodes) AND year = " . $search . ";";
			break;
	}
}
?>

<form class="form" action="films.php" method="GET" accept-charset="utf-8">
	<input class="input" type="text" name="search" placeholder="Type here"/>
	<br />
	<p style="font-size: 0.7em;">Type nothing to list all films</p>
	<fieldset>
		<legend >Search by</legend>
		<input class="searchby" type="radio" name="criteria" value="name" checked="true" />Name
		<input class="searchby" type="radio" name="criteria" value="year" />Year
	</fieldset>
	<input class="button" type="submit" name="submit" value="Search" />
</form>

<?php
//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';
?>

<hr />
<br />

<?php
//If user is logged in and admin, allow to add new film to catalogue
if (isset($_SESSION['uid']) && $_SESSION['admin']) {
	echo '<form action="filmform.php" method="POST" accept-charset="utf-8">';
	echo '<input type="submit" name="" value="Add film"/>';
	echo '</form>';
}

//Lists all available films
$films;
if (isset($_GET['search'])) {
	if(isset($_GET['error'])) $films = null;
	else $films = getFilms($query);
} else $films = getFilms();
if (!is_null($films)) foreach ($films as $film) echoFilmList($film);
else echoNoFilms();
mysqli_close($con);

include_once 'footer.php';
?>