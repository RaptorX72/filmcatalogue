<?php
session_start();
session_destroy();
echo 'Successful logout. Redirecting now...';
header("Location: ../pages/index.php");
?>