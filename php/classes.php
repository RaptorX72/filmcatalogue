<?php
//Classes
class User {
	private $id;
	private $username;
	private $email;
	private $picture;
	private $admin;

	public function getID() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getPicture() {
		return $this->picture;
	}

	public function getAdmin() {
		return $this->admin;
	}

	function __construct($i, $u, $e, $p, $a) {
		$this->id = $i;
		$this->username = $u;
		$this->email = $e;
		$this->picture = $p;
		$this->admin = $a;
	}
}

class Person {
	protected $id;
	protected $firstname;
	protected $lastname;
	protected $birthdate;
	protected $picture;

	public function getID() {
		return $this->id;
	}

	public function getFirstname() {
		return $this->firstname;
	}

	public function getLastname() {
		return $this->lastname;
	}

	public function getBirthdate() {
		return $this->birthdate;
	}

	public function getPicture() {
		return $this->picture;
	}

	function __construct($_id, $_fn, $_ln, $_bd, $_p) {
		$this->id = $_id;
		$this->firstname = $_fn;
		$this->lastname = $_ln;
		$this->birthdate = $_bd;
		$this->picture = $_p;
	}
}

class Star extends Person {
	private $star;

	public function getStar() {
		return $this->star;
	}

	function __construct($_id, $_fn, $_ln, $_bd, $_p, $_s) {
		parent::__construct($_id, $_fn, $_ln, $_bd, $_p);
		$this->star = $_s;
	}
}

class Comment {
	private $id;
	private $user;
	private $date;
	private $text;
	private $type;

	public function getID() {
		return $this->id;
	}

	public function getUser() {
		return $this->user;
	}

	public function getDate() {
		return $this->date;
	}

	public function getText() {
		return $this->text;
	}

	public function getType() {
		return $this->type;
	}

	function __construct($i, $u, $d, $t, $ty) {
		$this->id = $i;
		$this->user = $u;
		$this->date = $d;
		$this->text = $t;
		$this->type = $ty;
	}
}

class Season {
	private $films;
	private $seasonNumber;

	public function getFilms() {
		return $this->films;
	}

	public function getSeasonNumber() {
		return $this->seasonNumber;
	}

	function __construct($f, $sn) {
		$this->films = $f;
		$this->seasonNumber = $sn;
	}
}

class Series {
	private $id;
	private $name;
	private $seasons;
	private $seasonCount;
	private $picture;

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getPicture() {
		return $this->picture;
	}

	public function getSeasons() {
		return $this->seasons;
	}

	public function getSeasonCount() {
		return $this->seasonCount;
	}

	function __construct($_id, $n, $i, $s) {
		$this->id = $_id;
		$this->name = $n;
		$this->picture = $i;
		$this->seasons = $s;
		if (count($this->seasons) != 0) $this->seasonCount = count($this->seasons);
		else $this->seasons = 0;
	}
}

class Film {
	private $id;
	private $name;
	private $directors;
	private $writers;
	private $actors;
	private $year;
	private $rating;
	private $ratesum;
	private $ratecount;
	private $length;
	private $comments;
	private $picture;

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getDirectors() {
		return $this->directors;
	}

	public function getWriters() {
		return $this->writers;
	}

	public function getActors() {
		return $this->actors;
	}

	public function getYear() {
		return $this->year;
	}

	public function getRating() {
		return $this->rating;
	}

	public function getLength() {
		return $this->length;
	}

	public function getComments() {
		return $this->comments;
	}

	public function getPicture() {
		return $this->picture;
	}

	function __construct(
		$_id, $_name, $_dirs, $_wri, $_act,
		$_y, $_rs, $_rc, $_l, $_c, $_p
		) {
		$this->id = $_id;
		$this->name = $_name;
		$this->directors = $_dirs;
		$this->writers = $_wri;
		$this->actors = $_act;
		$this->year = $_y;
		$this->ratesum = $_rs;
		$this->ratecount = $_rc;
		$this->length = $_l;
		$this->comments = $_c;
		$this->picture = $_p;
		//If divider is zero or null, set rating to 0
		if ($_rc == 0 || $_rc == null) $this->rating = 0;
		else $this->rating = $_rs / $_rc;
	}
}

class Signup {
	private $con;
	private $username;
	private $salt;
	private $password;
	private $passwordconfirm;
	private $email;
	private $emailconfirm;

	public function getUsername() {
		return $this->username;
	}

	function  __construct($u, $p, $pc, $e, $ec, $c, $i) {
		$this->username = $u;
		$this->password = $p;
		$this->passwordconfirm = $pc;
		$this->email = $e;
		$this->emailconfirm = $ec;
		$this->con = $c;
	}

	//Returns true if every criteria is met
	private function Validate() {
		if (strlen($this->username) < 5 ||
			strlen($this->password) < 8 ||
			strlen($this->passwordconfirm) < 8 ||
			strlen($this->email) < 5 ||
			strlen($this->emailconfirm) < 5) throw new Exception("Field lengths too small");
		if (strlen($this->username) > 64 ||
			strlen($this->email) > 255 ||
			strlen($this->emailconfirm) > 255) throw new Exception("Field lengths too large");
		if ($this->password != $this->passwordconfirm) throw new Exception("Passwords don't match");
		if ($this->email != $this->emailconfirm) throw new Exception("Emails don't match");
		return true;
	}

	//Checks if username is already in database
	private function checkUsername() {
		$query = "SELECT id FROM Users WHERE username = '" . $this->username . "';";
		$res = mysqli_query($this->con, $query);
		if (mysqli_num_rows($res) > 0) throw new Exception("Username alredy exists");
		else return true;
	}

	//Checks if email is already in database
	private function checkEmail() {
		$query = "SELECT id FROM Users WHERE email = '" . $this->email . "';";
		$res = mysqli_query($this->con, $query);
		if (mysqli_num_rows($res) > 0) throw new Exception("Email alredy exists");
		else return true;
	}

	//Generates salt for password protection
	private function generateSalt() {
		$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/][{}";:?.>,<!@#$%^&*()-_=+|';
		$randStringLen = 16;
		$randString = "";
		for ($i = 0; $i < $randStringLen; $i++)
			$randString .= $charset[mt_rand(0, strlen($charset) - 1)];
		return $randString;
	}

	//Returns boolean
	public function Register() {
		try {
			if ($this->Validate() && $this->checkUsername() && $this->checkEmail()) {
				$this->salt = $this->generateSalt();
				$query = "INSERT INTO Users (username, password, salt, email, admin) VALUES ('" . $this->username . "', SHA2(CONCAT('" . $this->salt . "','" . $this->password . "'),512), '" . $this->salt . "', '" . $this->email . "', false);";
				$res = mysqli_query($this->con, $query);
				return $res;
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>