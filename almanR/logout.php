<?php
session_start();
require 'config/constants.php';

// destroying session and redirecting to main page
session_destroy();
header('location: ' . ROOT_URL);
die();
?>