<?php
// Initialize the session
session_start();

// unset session parameters.
unset($_SESSION['loggedin']);
unset($_SESSION['user']);
unset($_SESSION['email']);

// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>