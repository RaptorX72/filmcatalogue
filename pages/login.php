<?php
$pagename = 'login';
include_once 'header.php';
//If a user is already logged in, return to index
if (isset($_SESSION['uid'])) header("Location: ../index.php");
?>
<form class="form" action="../php/loginparse.php" method="POST" accept-charset="utf-8">
	<span class="text">Username</span>
	<input class="input" type="text" name="username"/>
	<br />
	<span class="text">Password</span>
	<input class="input" type="password" name="pass"/>
	<br />
    <input class="button" type="submit" name="Login" value="Login" />
    <br />
    <a class="goto_register" href="register.php" title="">Don't have an account? Register one for free!</a>
</form>
<?php
//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';
include_once 'footer.php';
?>