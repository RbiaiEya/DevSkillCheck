<?php
session_start();

unset($_SESSION['auth']);
unset($_SESSION['loggedInUser']);

header('location:../../index.php');

?>