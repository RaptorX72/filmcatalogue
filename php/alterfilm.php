<?php
include_once 'dbcon.php';
include_once 'imagehandler.php';

$id;
if (isset($_POST['filmid'])) $id = $_POST['filmid'];

$name;
$year;
$length;

$delete;
if (!isset($_POST['delete'])) {
	if (isset($_POST['name'])) $name = $_POST['name'];
	if (isset($_POST['year'])) $year = $_POST['year'];
	if (isset($_POST['length'])) $length = $_POST['length'];
	//Checks if input data is valid
	if ($name == "" ||
		$year == "" ||
		$length == "" ||
		!is_numeric($year) ||
		!is_numeric($length)) {
		//If form was an edit, return to film's page
		if (isset($id)) {
			header("Location: ../pages/film.php?fid=" . $id);
			die();
		} else {
			//If form was a new film, return to empty form
			header("Location: ../pages/filmform.php");
			die();
		}
	}
}

$query;
$queries = array();
//Sets query according to action
if (isset($_POST['delete'])) {
	array_push($queries, "DELETE FROM History WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM Directing WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM Writing WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM Plays WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM Episodes WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM FilmComments WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM Rating WHERE filmid = " . $id . ";");
	array_push($queries, "DELETE FROM Films WHERE id = " . $id . ";");
} else if (isset($id)) {
	$query = "UPDATE Films SET name = '" . $name . "', year = " . $year . ", length = " . $length;
	if(isset($_FILES['image'])) {
		if (deleteImage($id, 'Films')) {
			$img = uploadImage($_FILES['image']);
			if ($img->getResult()) $query .= ", image = '" . $img->getImageName() . "'";
		}
	}
	$query .= " WHERE id = " . $id;
} else {
	$query = "INSERT INTO Films (name, year, length";
	if(isset($_FILES['image'])) {
		$img = uploadImage($_FILES['image']);
		if ($img->getResult()) $query .= ", image) VALUES ('" . $name . "', " . $year . ", " . $length . ", '" . $image . "')";
		else $query .= ") VALUES ('" . $name . "', " . $year . ", " . $length . ")";
	} else $query .= ") VALUES ('" . $name . "', " . $year . ", " . $length . ")";
}

//Runs query
global $con;
if (isset($_POST['delete'])) {
	deleteImage($id, 'Films');
	foreach ($queries as $q) $res = mysqli_query($con, $q);
} else $res = mysqli_query($con, $query);
mysqli_close($con);

/*if (isset($_POST['delete'])) header("Location: ../pages/films.php");
else if (isset($id)) header("Location: ../pages/film.php?fid=". $id);
else header("Location: ../pages/films.php");*/
?>