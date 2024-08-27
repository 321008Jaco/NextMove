<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: Login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user is an agent
if ($_SESSION["user_type"] !== 'agent') {
    header("Location: index.php"); // Redirect to homepage if not an agent
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
</head>
<body>
    
</body>
</html>