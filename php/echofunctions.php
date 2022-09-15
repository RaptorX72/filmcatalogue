<?php
include_once 'loadfunctions.php';

function echoNoFilms() {
	echo '<p>No films found</p>';
}

function echoNoComments() {
	echo '<p>No comments found</p>';
}

function echoNoSeries() {
	echo '<p>No series found</p>';
}

function echoNoPeople() {
	echo '<p>No people found</p>';
}

function echoFilm($film, $showcomments = false) {
	global $con;

	//Displays every actor in film, appends * if starring in selected film
	function echoPersonListInFilm($person, $type) {
		global $film;
		echo '<br /><a href="../pages/person.php?pid=' . $person->getID() . '">' . $person->getFirstname() . " " . $person->getLastname();
		if ($person instanceof Star) if ($person->getStar()) echo '*';
		echo '   </a>';
		if(isset($_SESSION['admin']) && $_SESSION['admin']) {
			echo '<form action="../php/alterrole.php" method="POST" accept-charset="utf-8">';
			echo '<input type="text" name="pid" value="' . $person->getID() . '" hidden/>';
			echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
			echo '<input type="text" name="roletype" value="' . $type . '" hidden/>';
			echo '<input type="text" name="delete" value="true" hidden />';
			echo '<input type="submit" value="Delete"/>';
			echo '</form>';
		}
	}

	//If user is admin and logged in, allow to edit or delete film entry
	if (isset($_SESSION['uid']) && $_SESSION['admin']) {
		echo '<form action="filmform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
		echo '<input type="submit" name="" value="Edit"/>';
		echo '</form>';
		//
		echo '<form action="../php/alterfilm.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
		echo '<input type="text" name="delete" value="true" hidden />';
		echo '<input type="submit" name="" value="Delete"/>';
		echo '</form>';
		//
		echo '<form action="episodeform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
		$res = mysqli_query(
			$con,
			"SELECT * FROM Episodes WHERE filmid = " . $film->getID() . ";"
		);
		if (mysqli_num_rows($res) != 0) {
			echo '<input type="submit" name="" value="Edit episode relation"/>';
			echo '</form>';
			//Delete
			echo '<form action="../php/alterepisode.php" method="POST" accept-charset="utf-8">';
			echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
			echo '<input type="text" name="delete" value="true" hidden />';
			echo '<input type="submit" name="" value="Delete episode relation"/>';
			echo '</form>';
		} else {
			echo '<input type="submit" name="" value="Add episode relation"/>';
			echo '</form>';
		}
		//
		echo '<form action="roleform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
		echo '<input type="submit" name="" value="Add role"/>';
		echo '</form>';
	}
	echo '<h1><a href="film.php?fid=' . $film->getID() . '">' . $film->getName() . '</a></h1>';
	echo '<p>Year: ' . $film->getYear() . '</p>';
	echo '<p>Rating: ' . $film->getRating() . '</p>';
	//Checks if user is logged in and gets rating
	if (isset($_SESSION['uid'])) {
		global $con;
		$r = mysqli_query(
			$con,
			"SELECT rating FROM Rating WHERE filmid = " . $film->getID() . " AND userid = " . $_SESSION['uid'] . ";"
		);
		//If no rating is given, display form
		if (mysqli_num_rows($r) == 0) {
			echo '<form action="../php/ratefilm.php" method="POST" accept-charset="utf-8">';
			echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
			echo '<input type="text" name="userid" value="' . $_SESSION['uid'] . '" hidden/>';
			echo '<input type="number" name="rating" value="0" min="0" max="5" />';
			echo '<input type="submit" name="" value="Rate"/>';
			echo '</form>';
		}

	}
	echo '<p>Length: ' . $film->getLength() . ' min</p>';
	//Displays picture
	if (!empty($film->getPicture())) echo '<img src="../resources/img/' . $film->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png"/>';
	echo '<br />';
	echo 'Directors:';
	//Displays directors, writers and actors for film entry
	$directors = getDirectorsFromFilm($film->getID());
	if (is_null($directors)) echo '<p>No directors found!</p>';
	else foreach ($directors as $dir) echoPersonListInFilm($dir, "Directing");
	echo '<br />';
	echo 'Writers:';
	$writers = getWritersFromFilm($film->getID());
	if (is_null($writers)) echo '<p>No writers found!</p>';
	else foreach ($writers as $dir) echoPersonListInFilm($dir, "Writing");
	echo '<br />';
	echo 'Stars:';
	$stars = getStarsFromFilm($film->getID());
	if (is_null($stars)) echo '<p>No stars found!</p>';
	else foreach ($stars as $dir) echoPersonListInFilm($dir, "Plays");
	echo '<br />';
	//If comments are allowed, displays all available comments
	if ($showcomments) {
		$comments = getComments('film', $film->getID());
		if (!is_null($comments))
			foreach ($comments as $comment) echoComment($comment);
		else echoNoComments();
	}
	echo '<hr />';
}

function echoFilmList($film) {
	echo '<div style="border: 2px solid blue; margin: 15px;">';
	//If user is admin and logged in, allow to edit or delete film entry
	if (isset($_SESSION['uid']) && $_SESSION['admin']) {
		echo '<form action="filmform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
		echo '<input type="submit" name="" value="Edit"/>';
		echo '</form>';
		//
		echo '<form action="../php/alterfilm.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="filmid" value="' . $film->getID() . '" hidden/>';
		echo '<input type="text" name="delete" value="true" hidden />';
		echo '<input type="submit" name="" value="Delete"/>';
		echo '</form>';
	}
	echo '<h1><a href="film.php?fid=' . $film->getID() . '">' . $film->getName() . '</a></h1>';
	echo '<h3>Year: ' . $film->getYear() . '</h3>';
	echo '<h3>Rating: ' . $film->getRating() . '</h3>';
	if (!empty($film->getPicture())) echo '<img src="../resources/img/' . $film->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png"/>';
	echo '</div>';
}

function echoSeries($series, $showcomments = false) {
	//If user is admin and logged in, allow to edit or delete film entry
	if (isset($_SESSION['uid']) && $_SESSION['admin']) {
		echo '<form action="seriesform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="seriesid" value="' . $series->getID() . '" hidden/>';
		echo '<input type="submit" name="" value="Edit"/>';
		echo '</form>';
		//
		echo '<form action="../php/alterseries.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="seriesid" value="' . $series->getID() . '" hidden/>';
		echo '<input type="text" name="delete" value="true" hidden />';
		echo '<input type="submit" name="" value="Delete"/>';
		echo '</form>';
	}
	echo '<h1><a href="seria.php?sid=' . $series->getID() . '">' . $series->getName() . '</a></h1>';
	if (!empty($series->getPicture())) echo '<img src="../resources/img/' . $series->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png.png"/>';
	echo '<br />';
	echo '<p>Number of seasons: ' . $series->getSeasonCount() . '</p>';
	echo '<br />';
	//List seasons with episodes
	if ($series->getSeasonCount()) {
		foreach ($series->getSeasons() as $season) {
			echo '<p>Season ' . $season->getSeasonNumber() . '</p>';
			echo '<p>';
			foreach ($season->getFilms() as $film) {
				echo '<a href="film.php?fid=' . $film->getID() . '">' . $film->getName() . '</a>';
				echo '<br />';
			}
			echo '</p>';
			echo '<br />';
		}
	}
	//If comments are allowed, displays all available comments
	if ($showcomments) {
		$comments = getComments('series', $series->getID());
		if (!is_null($comments))
			foreach ($comments as $comment) echoComment($comment);
		else echoNoComments();
	}
	echo '<hr />';
}

function echoSeriesList($series) {
	echo '<div style="border: 2px solid blue; margin: 15px;">';
	//If user is admin and logged in, allow to edit or delete film entry
	if (isset($_SESSION['uid']) && $_SESSION['admin']) {
		echo '<form action="seriesform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="seriesid" value="' . $series->getID() . '" hidden/>';
		echo '<input type="submit" name="" value="Edit"/>';
		echo '</form>';
		//
		echo '<form action="../php/alterseries.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="seriesid" value="' . $series->getID() . '" hidden/>';
		echo '<input type="text" name="delete" value="true" hidden />';
		echo '<input type="submit" name="" value="Delete"/>';
		echo '</form>';
	}
	echo '<h1><a href="seria.php?sid=' . $series->getID() . '">' . $series->getName() . '</a></h1>';
	echo '<p>Number of seasons: ' . $series->getSeasonCount() . '</p>';
	if (!empty($series->getPicture())) echo '<img src="../resources/img/' . $series->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png"/>';
	echo '</div>';
}

function echoComment($comment) {
	echo '<h1 style="border-style: dotted;">' . $comment->getUser()->getUsername() . '</h1>';
	if (isset($_SESSION['uid'])) {
		//If logged in user is owner of comment, allow user to edit
		if($_SESSION['uid'] == $comment->getUser()->getID()) {
			echo '<form action="commentform.php" method="POST" accept-charset="utf-8">';
			echo '<input type="text" name="userid" value="' . $_SESSION['uid'] . '" hidden/>';
			echo '<input type="text" name="type" value="' . $comment->getType() . '" hidden/>';
			echo '<input type="text" name="cid" value="' . $comment->getID() . '" hidden/>';
			echo '<input type="submit" name="" value="Edit"/>';
			echo '</form>';
		}
		//If user is owner of comment or admin, allow user to delete
		if($_SESSION['admin'] ||
		$_SESSION['uid'] == $comment->getUser()->getID()) {
			echo '<form action="../php/altercomment.php" method="POST" accept-charset="utf-8">';
			echo '<input type="text" name="delete" value="true" hidden />';
			echo '<input type="text" name="type" value="' . $comment->getType() . '" hidden/>';
			echo '<input type="text" name="cid" value="' . $comment->getID() . '" hidden/>';
			echo '<input type="text" name="delete" value="true" hidden />';
			echo '<input type="submit" name="" value="Delete"/>';
			echo '</form>';
		}
	}
	if (!empty($comment->getUser()->getPicture())) echo '<img src="../resources/img/' . $comment->getUser()->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png"/>';
	echo '<p>' . $comment->getDate() . '</p>';
	echo '<p>' . $comment->getText() . '</p>';
}

function echoPerson($person) {
	echo '<h1>' . $person->getFirstname() . " " . $person->getLastname() . '</h1>';
	echo '<p>' . $person->getBirthdate() . '</p>';
	if (!empty($person->getPicture())) echo '<img src="../resources/img/' . $person->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png"/>';
	echo '<br />';
	//If person is a star, display if starring in any film
	if ($person instanceof Star) {
		if ($person->getStar()) echo '<p>Is a star in a film!</p>';
		else echo '<p>Is not a star in any film!</p>';
	}
	function echoFilmsList($type) {
		global $person;
		//Selects every film the person is associated with
		$films = getFilms(
			"SELECT Films.id, Films.name, Films.year, Films.length, Films.image FROM Films, " . ucfirst($type) . " WHERE humanid = " . $person->getID() . " AND filmid = Films.id;"
		);
		if (!is_null($films))
			foreach ($films as $film)
				echo '<br /><a href="film.php?fid=' . $film->getID() . '">' . $film->getName() . ' ' . '(' . $film->getYear() . ')</a>';
		else echo '<p>...</p>';
	}
	//Displays what films the entry directs, writes or plays in
	echo 'Directs:';
	echoFilmsList('directing');
	echo '<br />';
	echo 'Writers:';
	echoFilmsList('writing');
	echo '<br />';
	echo 'Stars:';
	echoFilmsList('plays');
	echo '<br />';

	//If user is admin and logged in, allow to edit or delete person entry
	echo '<form action="personform.php" method="POST" accept-charset="utf-8">';
	echo '<input type="text" name="pid" value="' . $person->getID() . '" hidden/>';
	echo '<input type="submit" name="" value="Edit"/>';
	echo '</form>';
	//
	echo '<form action="../php/alterperson.php" method="POST" accept-charset="utf-8">';
	echo '<input type="text" name="pid" value="' . $person->getID() . '" hidden/>';
	echo '<input type="text" name="delete" value="true" hidden />';
	echo '<input type="submit" name="" value="Delete"/>';
	echo '</form>';
}

//Displays every actor
function echoPeopleList($person) {
	echo '<div style="border: 2px solid blue; margin: 15px;">';
	//If user is admin and logged in, allow to edit or delete person entry
	if (isset($_SESSION['uid']) && $_SESSION['admin']) {
		echo '<form action="personform.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="pid" value="' . $person->getID() . '" hidden/>';
		echo '<input type="submit" name="" value="Edit"/>';
		echo '</form>';
		//
		echo '<form action="../php/alterperson.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="pid" value="' . $person->getID() . '" hidden/>';
		echo '<input type="text" name="delete" value="true" hidden />';
		echo '<input type="submit" name="" value="Delete"/>';
		echo '</form>';
	}
	if (!empty($person->getPicture())) echo '<img src="../resources/img/' . $person->getPicture() . '"/>';
	else echo '<img src="../resources/img/nopicture.png"/>';
	echo '<a href="../pages/person.php?pid=' . $person->getID() . '">' . $person->getFirstname() . " " . $person->getLastname() . ' (' . $person->getBirthdate() . ')</a>';
	echo '</div>';
}

//Displays all available users
function echoUserList($user) {
	echo '<li><a href="user.php?userid=' . $user->getID() . '" title="">' . $user->getUsername() . ' | ' . $user->getEmail() . '</a>';
	//If logged in user is not the same as entry, allow actions
	if ($user->getID() != $_SESSION['uid']) {
		echo '<form action="../php/editadmin.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="userid" value="' . $user->getID() . '" hidden/>';
		echo '<input type="text" name="adminstatus" value="' . $user->getAdmin() . '" hidden/>';
		if ($user->getAdmin()) echo '<input type="submit" name="" value="Revoke admin"/>';
		else echo '<input type="submit" name="" value="Grant admin"/>';
		echo '</form>';
		//
		echo '<form action="../php/alteruser.php" method="POST" accept-charset="utf-8">';
		echo '<input type="text" name="userid" value="' . $user->getID() . '" hidden/>';
		echo '<input type="text" name="delete" value="' . true . '" hidden/>';
		echo '<input type="submit" name="" value="Delete user"/>';
		echo '</form>';
	}
	echo '</li>';
}

?>