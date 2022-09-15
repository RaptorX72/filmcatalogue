<?php
$pagename = 'person';
include_once 'header.php';
include_once '../php/echofunctions.php';
include_once '../php/dbcon.php';

//Gets person of corresponding id
$person = getPerson($_GET['pid']);
//Displays person
echoPerson($person);
//Display error if have any
if (isset($_GET['error'])) echo '<b>' . $_GET['error'] . '</b>';
mysqli_close($con);

include_once 'footer.php';
?>