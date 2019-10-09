<?php
session_start();

unset($_SESSION['email']);
unset($_SESSION['userId']);

session_destroy();

header("Location: index.php");

?>