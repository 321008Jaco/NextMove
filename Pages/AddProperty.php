<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

// Database connection
require_once "../database.php"; // Assuming you have a separate file for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipcode"];
    $propertyType = $_POST["propertyType"];
    $garageSpace = $_POST["garageSpace"];
    $bedrooms = $_POST["bedrooms"];
    $bathrooms = $_POST["bathrooms"];
    $squareMeters = $_POST["squareMeters"];
    $imageOne = $_POST["imageOne"];
    $imageTwo = $_POST["imageTwo"];
    $imageThree = $_POST["imageThree"];
    $imageFour = $_POST["imageFour"];
    $agentID = $_SESSION["user_id"]; // Assuming agent ID is stored in session

    // Insert property into the pendingproperties table
    $sql = "INSERT INTO pendingproperties (Title, Description, Price, Address, City, State, Zipcode, PropertyType, Status, AgentID, GarageSpace, Bedrooms, Bathrooms, SquareMeters, ImageOne, ImageTwo, ImageThree, ImageFour)
            VALUES ('$title', '$description', '$price', '$address', '$city', '$state', '$zipcode', '$propertyType', 'pending', '$agentID', '$garageSpace', '$bedrooms', '$bathrooms', '$squareMeters', '$imageOne', '$imageTwo', '$imageThree', '$imageFour')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Property added successfully! Awaiting admin approval.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/AddProperty.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <nav class="navbar">
            <div class="logo">Logo</div>
            <div class="nav-center">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../Pages/Properties.php">Properties</a></li>
                    <li><a href="../Pages/Book.php">Book Agent</a></li>
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

    <div class="container">
        <h1>Add Property</h1>
        <form action="AddProperty.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="mb-3">
                <label for="zipcode" class="form-label">Zipcode</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode" required>
            </div>
            <div class="mb-3">
                <label for="propertyType" class="form-label">Property Type</label>
                <select class="form-control" id="propertyType" name="propertyType" required>
                    <option value="house">House</option>
                    <option value="apartment">Apartment</option>
                    <option value="office">Office</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="garageSpace" class="form-label">Garage Space</label>
                <input type="number" class="form-control" id="garageSpace" name="garageSpace" required>
            </div>
            <div class="mb-3">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" required>
            </div>
            <div class="mb-3">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <input type="number" class="form-control" id="bathrooms" name="bathrooms" required>
            </div>
            <div class="mb-3">
                <label for="squareMeters" class="form-label">Square Meters</label>
                <input type="number" class="form-control" id="squareMeters" name="squareMeters" required>
            </div>
            <div class="mb-3">
                <label for="imageOne" class="form-label">Image One URL</label>
                <input type="text" class="form-control" id="imageOne" name="imageOne" required>
            </div>
            <div class="mb-3">
                <label for="imageTwo" class="form-label">Image Two URL</label>
                <input type="text" class="form-control" id="imageTwo" name="imageTwo">
            </div>
            <div class="mb-3">
                <label for="imageThree" class="form-label">Image Three URL</label>
                <input type="text" class="form-control" id="imageThree" name="imageThree">
            </div>
            <div class="mb-3">
                <label for="imageFour" class="form-label">Image Four URL</label>
                <input type="text" class="form-control" id="imageFour" name="imageFour">
            </div>
            <button type="submit" class="btn btn-primary">Submit Property</button>
        </form>
    </div>
</body>
</html>
