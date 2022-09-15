<?php
include_once 'classes.php';

//Gets and returns one user via id
function getUser($id) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT id, username, email, image, admin FROM Users WHERE id = " . $id . ";"
	);
	$row = mysqli_fetch_assoc($res);
	$user = new User(
		$row['id'],
		$row['username'],
		$row['email'],
		$row['image'],
		$row['admin']
	);
	return $user;
}

//Returns array of users according to query
function getUsers($query = "SELECT id, username, email, image, admin FROM Users") {
	global $con;
	$res = mysqli_query($con, $query);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$users = array();
		while($row = mysqli_fetch_assoc($res)) {
			$user = new User(
				$row['id'],
				$row['username'],
				$row['email'],
				$row['image'],
				$row['admin']
			);
			array_push($users, $user);
		}
		return $users;
	}
}

//Returns array of comments belonging to a single entry
function getComments($type, $id) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT id, userid, postdate, posttext FROM " . ucfirst($type) . "Comments WHERE " . $type . "id = " . $id . ";"
	);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$comments = array();
		while($row = mysqli_fetch_assoc($res)) {
			$comment = new Comment(
				$row['id'],
				getUser($row['userid']),
				$row['postdate'],
				$row['posttext'],
				$type
			);
			array_push($comments, $comment);
		}
		return $comments;
	}
}

//Returns array of people according to query
function getPeople($query = "SELECT * FROM Humans") {
	global $con;
	$res = mysqli_query($con, $query);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$people = array();
		while($row = mysqli_fetch_assoc($res)) {
			$person = new Person(
				$row['id'],
				$row['firstname'],
				$row['lastname'],
				$row['birthdate'],
				$row['image']
			);
			array_push($people, $person);
		}
		return $people;
	}
}

//Returns a single person via id
function getPerson($id) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT id, firstname, lastname, birthdate, image FROM Humans WHERE id = " . $id . ";"
	);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$row = mysqli_fetch_assoc($res);
		$person = new Person(
			$row['id'],
			$row['firstname'],
			$row['lastname'],
			$row['birthdate'],
			$row['image']
		);
		return $person;
	}
}

//Returns array of directors for film entry
function getDirectorsFromFilm($filmid) {
	$query = "SELECT id, firstname, lastname, birthdate, image FROM Humans, Directing WHERE
	Humans.id = Directing.humanid AND Directing.filmid = " . $filmid . ";";
	return getPeople($query);
}

//Returns array of writers for film entry
function getWritersFromFilm($filmid) {
	$query = "SELECT id, firstname, lastname, birthdate, image FROM Humans, Writing WHERE
	Humans.id = Writing.humanid AND Writing.filmid = " . $filmid . ";";
	return getPeople($query);
}

//Returns array of stars for film entry
function getStarsFromFilm($filmid) {
	// * New function due to different constructor
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT id, firstname, lastname, birthdate, image, star FROM Humans, Plays WHERE Humans.id = Plays.humanid AND Plays.filmid = " . $filmid . ";"
	);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$people = array();
		while($row = mysqli_fetch_assoc($res)) {	
			$person = new Star(
				$row['id'],
				$row['firstname'],
				$row['lastname'],
				$row['birthdate'],
				$row['image'],
				$row['star']);
			array_push($people, $person);
		}
		return $people;
	}
}

//Returns a single film via id
function getFilm($id) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT name, year, length, image FROM Films WHERE id = " . $id . ";"
	);
	if (mysqli_num_rows($res) == 0) return null;
	$row = mysqli_fetch_assoc($res);
	//Gets total number of votes
	$q1r = mysqli_query(
		$con,
		"SELECT COUNT(userid) FROM Rating WHERE filmid = " . $id . ";"
	);
	//Gets sum of total votes
	$q2r = mysqli_query(
		$con,
		"SELECT SUM(rating) FROM Rating WHERE filmid = ". $id . ";"
	);
	$ratecount = $q1r->fetch_row()[0];
	$ratesum = $q2r->fetch_row()[0];
	//Creates film object
	$film = new Film(
		$id, $row['name'],
		getDirectorsFromFilm($id),
		getWritersFromFilm($id),
		getStarsFromFilm($id),
		$row['year'],
		$ratesum,
		$ratecount,
		$row['length'],
		getComments('film', $id),
		$row['image']
	);
	return $film;
}

//Returns array of films according to query
function getFilms(
	//TODO: Optimize query
	$query = "SELECT id, name, year, length, image FROM Films WHERE
		id NOT IN (SELECT filmid FROM Episodes);") {
	global $con;
	$res = mysqli_query($con, $query);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$films = array();
		while($row = mysqli_fetch_assoc($res)) {
			//Gets total number of votes
			$q1r = mysqli_query(
				$con,
				"SELECT COUNT(userid) FROM Rating WHERE filmid = " . $row['id'] . ";"
			);
			//Gets total sum of votes
			$q2r = mysqli_query(
				$con,
				"SELECT SUM(rating) FROM Rating WHERE filmid = ". $row['id'] . ";"
			);
			$ratecount = $q1r->fetch_row()[0];
			$ratesum = $q2r->fetch_row()[0];
			//Creates object
			$film = new Film(
				$row['id'],
				$row['name'],
				getDirectorsFromFilm($row['id']),
				getWritersFromFilm($row['id']),
				getStarsFromFilm($row['id']),
				$row['year'],
				$ratesum,
				$ratecount,
				$row['length'],
				getComments('film', $row['id']),
				$row['image']
			);
			array_push($films, $film);
		}
		return $films;
	}
}

function getSeasons($id) {
	global $con;
	//Gets the total number of seasons for a series
	$res = mysqli_query(
		$con,
		"SELECT DISTINCT COUNT(season) FROM Episodes WHERE seriesid = " . $id . ";"
	);
	if (mysqli_num_rows($res) == 0) return null;
	//Gets every episode for the series
	$res = mysqli_query(
		$con,
		"SELECT filmid, season FROM Episodes WHERE seriesid = " . $id . " ORDER BY season ASC;"
	);
	//Set up temporary variables
	$seasons = array();
	$films = array();
	$currentSeason = null;
	$lastSN = null;
	while ($row = mysqli_fetch_assoc($res)) {
		if (is_null($currentSeason)) $currentSeason = $row['season'];
		//If we arrive to a new season, add the previous to array
		if ($row['season'] != $currentSeason) {
			$season = new Season($films, $currentSeason);
			array_push($seasons, $season);
			//Resets temp variable
			$films = array();
			$currentSeason = $row['season'];
		}
		//Add current film to season list
		$film = getFilm($row['filmid']);
		array_push($films, $film);
		$lastSN = $row['season'];
	}
	//Add the final season which falls outside of the while loop due to design
	$season = new Season($films, $lastSN);
	array_push($seasons, $season);
	return $seasons;
}

//Returns a single series via id
function getOneSeries($id) {
	global $con;
	$res = mysqli_query(
		$con,
		"SELECT name, image FROM Series WHERE id = " . $id . ";"
	);
	if (mysqli_num_rows($res) == 0) return null;
	$row = mysqli_fetch_assoc($res);
	//Creates series object
	$series = new Series(
		$id,
		$row['name'],
		$row['image'],
		getSeasons($id)
	);
	return $series;
}

//Returns array of series according to query
function getSeries(
	$query = "SELECT id, name, image FROM Series;") {
	global $con;
	$res = mysqli_query($con, $query);
	if (mysqli_num_rows($res) == 0) return null;
	else {
		$series = array();
		while($row = mysqli_fetch_assoc($res)) {
			//Creates object
			$oneseries = new Series(
				$row['id'],
				$row['name'],
				$row['image'],
				getSeasons($row['id'])
			);
			array_push($series, $oneseries);
		}
		return $series;
	}
}
?>