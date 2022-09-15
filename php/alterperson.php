<?php
include_once 'dbcon.php';
include_once 'imagehandler.php';

$id;
if (isset($_POST['pid'])) $id = $_POST['pid'];

$firstname;
$lastname;
$birthdate;

function validateDate($value) {
	$comp = explode('-', $value);
	if (count($comp) != 3) return false;
	foreach ($comp as $val) if (!is_numeric($val)) return false;
	if ($comp[0] < 0) return false;
	if ($comp[1] < 1 || $comp[1] > 12) return false;
	if ($comp[2] < 1 || $comp[2] > 31) return false;
	if ($comp[1] == 2 && $comp[2] > 29) return false;
	return true;
}

$delete;
if (!isset($_POST['delete'])) {
	if (isset($_POST['firstname'])) $firstname = $_POST['firstname'];
	if (isset($_POST['lastname'])) $lastname = $_POST['lastname'];
	if (isset($_POST['birthdate'])) $birthdate = $_POST['birthdate'];
	//Checks if input data is valid
	if ($firstname == "" ||
		$lastname == "" ||
		$birthdate == "" ||
		!validateDate($birthdate)) {
		//If form was an edit, return to person's page
		if (isset($id)) {
			header("Location: ../pages/person.php?pid=" . $id);
			die();
		} else {
			//If form was a new person, return to empty form
			header("Location: ../pages/personform.php");
			die();
		}
	}
}

$query;
$queries = array();
//Sets query according to action
if (isset($_POST['delete'])) {
	array_push($queries, "DELETE FROM Directing WHERE humanid = " . $id . ";");
	array_push($queries, "DELETE FROM Writing WHERE humanid = " . $id . ";");
	array_push($queries, "DELETE FROM Plays WHERE humanid = " . $id . ";");
	array_push($queries, "DELETE FROM Humans WHERE id = " . $id . ";");
} else if (isset($id)) {
	$query = "UPDATE Humans SET firstname = '" . $firstname . "', lastname = '" . $lastname . "', birthdate = DATE('" . $birthdate . "')";
	if(isset($_FILES['image'])) {
		if (deleteImage($id, 'Series')) {
			$img = uploadImage($_FILES['image']);
			if ($img->getResult()) $query .= ", image = '" . $img->getImageName() . "'";
		}
	}
	$query .= " WHERE id = " . $id;
} else {
	$query = "INSERT INTO Humans (firstname, lastname, birthdate) VALUES ('" . $firstname . "', '" . $lastname . "', DATE('" . $birthdate . "'));";

	$query = "INSERT INTO Humans (firstname, lastname, birthdate";
	if(isset($_FILES['image'])) {
		$img = uploadImage($_FILES['image']);
		if ($img->getResult()) $query .= ", image) VALUES ('" . $firstname . "', '" . $lastname . "', DATE('" . $birthdate . "'), '" . $img->getImageName() . "')";
		else $query .= ") VALUES ('" . $firstname . "', '" . $lastname . "', DATE('" . $birthdate . "'))";
	} else $query .= ") VALUES ('" . $firstname . "', '" . $lastname . "', DATE('" . $birthdate . "'))";
}

//Runs query
global $con;
if (isset($_POST['delete'])) {
	deleteImage($id, 'Humans');
	foreach ($queries as $q) $res = mysqli_query($con, $q);
} else $res = mysqli_query($con, $query);
mysqli_close($con);

if (isset($_POST['delete'])) header("Location: ../pages/people.php");
else if (isset($id)) header("Location: ../pages/person.php?pid=". $id);
else header("Location: ../pages/people.php");
?>