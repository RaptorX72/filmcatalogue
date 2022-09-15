<?php
$pagename = 'series';
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
			$query = "SELECT id, name, image FROM Series WHERE name LIKE '%" . $search . "%';";
			break;
		case 'epname':
			$query = "SELECT DISTINCT Series.id, Series.name, Series.image FROM Series, Episodes, Films WHERE Series.id = Episodes.seriesid AND Films.id = Episodes.filmid AND Films.name LIKE '%" . $search . "%';";
			break;
	}
}
?>

<form class="form" action="series.php" method="GET" accept-charset="utf-8">
	<input class="input" type="text" name="search" placeholder="Type here"/>
	<br />
	<p style="font-size: 0.7em;">Type nothing to list all films</p>
	<fieldset>
		<legend >Search by</legend>
		<input class="searchby" type="radio" name="criteria" value="name" checked="true" />Name
		<input class="searchby" type="radio" name="criteria" value="epname" />Episode name
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
	echo '<form action="seriesform.php" method="POST" accept-charset="utf-8">';
	echo '<input type="submit" name="" value="Add series"/>';
	echo '</form>';
}

//Lists all available series
$series;
if (isset($_GET['search'])) {
	if(isset($_GET['error'])) $series = null;
	else $series = getSeries($query);
} else $series = getSeries();

if (!is_null($series)) foreach ($series as $seria) echoSeriesList($seria);
else echoNoseries();
mysqli_close($con);

include_once 'footer.php';
?>