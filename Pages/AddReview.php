<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['rating'])) {
        echo "Please select a rating.";
        exit();
    }
    
    $rating = $_POST['rating'];
    $reviewText = $_POST['reviewText'];
    $userID = $_SESSION['user_id'];
    $propertyID = $_POST['propertyID'];

    // Insert the review and rating into the database
    $sql = "INSERT INTO review (property_id, id, ReviewText, Rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $propertyID, $userID, $reviewText, $rating);

    if ($stmt->execute()) {
        header("Location: Individual.php?PropertyID=" . $propertyID);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
