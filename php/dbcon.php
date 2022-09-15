<?php
if(session_status() == 1) session_start();
$_host = "localhost";
$_user = "root";
$_pass = "";
$_dbname = "rf1_testdb";
//Sets up connection to database
$con = mysqli_connect($_host, $_user, $_pass, $_dbname);
if (!$con) die("Connection failed: " . mysqli_connect_error());

//Sets charset
mysqli_query($con,"SET CHARACTER SET 'utf8'");
?>