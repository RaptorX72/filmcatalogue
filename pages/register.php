<?php
$pagename = 'register';
include_once 'header.php';
//If user already logged in, return to index
if (isset($_SESSION['uid'])) header("Location: index.php");
?>
<form class= "form" action="../php/registerparse.php" method="POST" accept-charset="utf-8">
	<span class="text">Username</span>
	<input class= "input" type="text" name="username" />
	<br />
	<span class="text">Password</span>
	<input class= "input" type="password" name="pass" />
	<br />
	<span class="text">Password confirm</span>
	<input class= "input" type="password" name="passc" />
	<br />
	<span class="text">Email</span>
	<input class= "input" type="email" name="email" />
	<br />
	<span class="text">Email confirm</span>
	<input class= "input" type="email" name="emailc" />
	<br />
	<input class="button" type="submit" name="Register" value="Register" />
</form>
<?php
//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';

include_once 'footer.php';
?>