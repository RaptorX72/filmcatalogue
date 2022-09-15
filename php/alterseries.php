<?php
include_once 'dbcon.php';
include_once 'imagehandler.php';

global $con;
$id;
$name;
if (isset($_POST['seriesid'])) $id = $_POST['seriesid'];



if (!isset($_POST['delete'])) {
	if (isset($_POST['name'])) $name = $_POST['name'];
	//Checks if input data is valid
	if ($name == "") {
		//If form was an edit, return to seria's page
		if (isset($id)) {
			header("Location: ../pages/seria.php?sid=" . $id);
			die();
		} else {
			//If form was a new series, return to empty form
			header("Location: ../pages/seriesform.php");
			die();
		}
	}
}

$query;
$queries = array();
//Sets query according to action
if (isset($_POST['delete'])) {
	$r = mysqli_query($con, "SELECT filmid FROM Episodes WHERE seriesid = " . $id);
	$filmidstring = null;
	$ids = array();
	if (mysqli_num_rows($r) > 0) {
		while($ro = mysqli_fetch_assoc($r)) array_push($ids, $ro['filmid']);
		$c = count($ids);
		$str = "(";
		for ($i=0; $i < $c; $i++) {
			$str .= $ids[$i];
			if ($i != $c - 1) $str .= ", ";
		}
		$str .= ")";
		$filmidstring = $str;
	}
	if(!is_null($filmidstring)) {
		array_push($queries, "DELETE FROM Films WHERE id IN " . $filmidstring);
		foreach ($ids as $i) deleteImage($i, 'Films');
	}
	array_push($queries, "DELETE FROM Episodes WHERE seriesid = " . $id);
	array_push($queries, "DELETE FROM Series WHERE id = " . $id);

} else if (isset($id)) {
	$query = "UPDATE Series SET name = '" . $name . "'";
	if(isset($_FILES['image'])) {
		if (deleteImage($id, 'Series')) {
			$img = uploadImage($_FILES['image']);
			if ($img->getResult()) $query .= ", image = '" . $img->getImageName() . "'";
		}
	}
	$query .= " WHERE id = " . $id;
} else {
	$query = "INSERT INTO Series (name";
	if(isset($_FILES['image'])) {
		$img = uploadImage($_FILES['image']);
		if ($img->getResult()) $query .= ", image) VALUES ('" . $name . "', '" . $img->getImageName() . "')";
		else $query .= ") VALUES ('" . $name . "')";
	} else $query .= ") VALUES ('" . $name . "')";
}

//Runs query
if (isset($_POST['delete'])) {
	deleteImage($id, 'Series');
	foreach ($queries as $q) $res = mysqli_query($con, $q);
}
else $res = mysqli_query($con, $query);
mysqli_close($con);

if (isset($_POST['delete'])) header("Location: ../pages/films.php");
else if (isset($id)) header("Location: ../pages/film.php?fid=". $id);
else header("Location: ../pages/films.php");
?>