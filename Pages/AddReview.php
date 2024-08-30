<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propertyID = $_POST['propertyID'];
    $reviewText = $_POST['reviewText'];
    $userID = $_SESSION['user_id']; // Assuming you store the user's ID in the session when they log in

    // Prepare the SQL statement to insert the review
    $sql = "INSERT INTO review (ProperyID, id, ReviewText) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $propertyID, $userID, $reviewText);

    if ($stmt->execute()) {
        // Redirect back to the individual property page after successfully adding the review
        header("Location: Individual.php?PropertyID=" . $propertyID);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
