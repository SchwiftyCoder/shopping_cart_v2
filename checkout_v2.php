<?php
session_start();

// Clear the entire session
session_destroy();

// Redirect to the orders.php page
header("Location: orders.php");
exit();
?>
