<?php
include 'session.php';

// Start or resume the session
session_start();

// Terminate the session
session_unset();
session_destroy();

// Redirect to index.html after logout
header("Location: index.html");
exit();
?>
