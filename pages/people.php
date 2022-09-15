<?php
$pagename = 'people';
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
			$query = "SELECT * FROM Humans WHERE firstname LIKE '%" . $search . "%' OR lastname LIKE '%" . $search . "%';";
			break;
		case 'year':
			if (!is_numeric($search)) {
				header("Location: people.php?error=Year not in number format");
				die();
			}
			$query = "SELECT * FROM Humans WHERE YEAR(birthdate) = " . $search . ";";
			break;
		case 'month':
			if (!is_numeric($search) || ($search > 12 || $search < 1)) {
				header("Location: people.php?error=Month not in number format");
				die();
			}
			$query = "SELECT * FROM Humans WHERE MONTH(birthdate) = " . $search . ";";
			break;
		case 'day':
			if (!is_numeric($search) || ($search > 31 || $search < 1)) {
				header("Location: people.php?error=Day not in number format");
				die();
			}
			$query = "SELECT * FROM Humans WHERE DAY(birthdate) = " . $search . ";";
			break;
	}
}
?>

<form class="form" action="people.php" method="GET" accept-charset="utf-8">
	<input class="input" type="text" name="search" placeholder="Type here"/>
	<br />
	<p style="font-size: 0.7em;">Type nothing to list all people</p>
	<fieldset>
		<legend >Search by</legend>
		<input class="searchby" type="radio" name="criteria" value="name" checked="true" />Name
		<input class="searchby" type="radio" name="criteria" value="year" />Year
		<input class="searchby" type="radio" name="criteria" value="month" />Month
		<input class="searchby" type="radio" name="criteria" value="day" />Day
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
//If user is logged in and admin, allow to add new person to catalogue
if (isset($_SESSION['uid']) && $_SESSION['admin']) {
	echo '<form action="personform.php" method="POST" accept-charset="utf-8">';
	echo '<input type="submit" name="" value="Add person"/>';
	echo '</form>';
}

//Lists all available people
$people;
if (isset($_GET['search'])) {
	if(isset($_GET['error'])) $people = null;
	else $people = getPeople($query);
} else $people = getPeople();

if (!is_null($people)) foreach ($people as $person) echoPeopleList($person);
else echoNoPeople();

//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';

mysqli_close($con);

include_once 'footer.php';
?>