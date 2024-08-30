<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate that a rating was selected
    if (!isset($_POST['rating'])) {
        echo "Please select a rating.";
        exit();
    }
    
    $rating = $_POST['rating']; // Get the rating from the form
    $reviewText = $_POST['reviewText']; // Get the review text
    $userID = $_SESSION['user_id']; // Assuming user ID is stored in the session
    $propertyID = $_POST['propertyID']; // Get the property ID from the form

    // Insert the review and rating into the database
    $sql = "INSERT INTO review (property_id, id, ReviewText, Rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $propertyID, $userID, $reviewText, $rating);

    if ($stmt->execute()) {
        // Redirect back to the individual property page after successfully adding the review
        header("Location: Individual.php?PropertyID=" . $propertyID);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
