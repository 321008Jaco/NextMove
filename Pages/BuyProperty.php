<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Get the PropertyID from the URL
$propertyID = $_GET['PropertyID'];

// Query to get the property details
$sql = "SELECT Title, Price, Address, City, State, Zipcode, Bedrooms, Bathrooms, GarageSpace, SquareMeters FROM properties WHERE PropertyID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the status of the property to "sold"
    $updateSql = "UPDATE properties SET Status = 'sold' WHERE PropertyID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $propertyID);
    if ($updateStmt->execute()) {
        header("Location: ../Pages/individual.php?PropertyID=" . $propertyID);
        exit();
    } else {
        echo "Error: Could not update the property status.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Property</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/BuyProperty.css">
</head>
<body>

    <nav class="navbar">
    <div class="logo">
        <a href="#">
            <img src="../Assets/Logo.png" alt="Logo" style="height: 60px;">
        </a>
    </div>
            <div class="nav-center">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../Pages/Properties.php">Properties</a></li>
                    <li><a href="../Pages/Book.php">Book Agent</a></li>
                    <li><a href="../Pages/Morgage.php">Mortgage Calculator</a></li>
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'agent'): ?>
                    <li><a href="../Pages/AddProperty.php">Add Property</a></li>
                <?php endif; ?>
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'admin'): ?>
                    <li><a href="../Pages/AdminApproval.php">Approval</a></li>
                <?php endif; ?>
                </ul>
            </div>
            <a href="../logout.php" class="btn btn-warning">Logout</a>
    </nav>

        <div class="header"></div>

<div class="container my-4">
    <h1>Buy Property: <?php echo htmlspecialchars($property['Title']); ?></h1>
    <p><strong>Price:</strong> <?php echo htmlspecialchars($property['Price']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($property['Address']); ?>, <?php echo htmlspecialchars($property['City']); ?>, <?php echo htmlspecialchars($property['State']); ?>, <?php echo htmlspecialchars($property['Zipcode']); ?></p>
    <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['Bedrooms']); ?></p>
    <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['Bathrooms']); ?></p>
    <p><strong>Garage Space:</strong> <?php echo htmlspecialchars($property['GarageSpace']); ?></p>
    <p><strong>Square Meters:</strong> <?php echo htmlspecialchars($property['SquareMeters']); ?> m²</p>

    <form method="POST" action="">
        <button type="submit" class="btn btn-success">Buy This Property</button>
        <a href="Individual.php?PropertyID=<?php echo $propertyID; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<footer class="footer">
    <div class="social-container">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-google-plus-g"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
    <ul class="footer-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">News</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Our Team</a></li>
    </ul>
    <div class="footer-bottom">
        <p>&copy; 2024; Designed by <span>Jaco Mostert</span></p>
    </div>
</footer>

</body>
</html>
