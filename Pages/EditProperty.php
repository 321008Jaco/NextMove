<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Get the PropertyID from the URL
$propertyID = $_GET['PropertyID'];

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $price = $_POST['price'] ?? null;
    $address = $_POST['address'] ?? null;
    $city = $_POST['city'] ?? null;
    $state = $_POST['state'] ?? null;
    $zipcode = $_POST['zipcode'] ?? null;
    $propertyType = $_POST['propertyType'] ?? null;
    $status = $_POST['status'] ?? null;
    $garageSpace = $_POST['garageSpace'] ?? null;
    $bedrooms = $_POST['bedrooms'] ?? null;
    $bathrooms = $_POST['bathrooms'] ?? null;
    $squareMeters = $_POST['squareMeters'] ?? null;
    $imageOne = $_POST['imageOne'] ?? null;
    $imageTwo = $_POST['imageTwo'] ?? null;
    $imageThree = $_POST['imageThree'] ?? null;
    $imageFour = $_POST['imageFour'] ?? null;

    // Update the property in the database
    $updateSql = "UPDATE properties SET Title = ?, Description = ?, Price = ?, Address = ?, City = ?, State = ?, Zipcode = ?, PropertyType = ?, Status = ?, GarageSpace = ?, Bedrooms = ?, Bathrooms = ?, SquareMeters = ?, ImageOne = ?, ImageTwo = ?, ImageThree = ?, ImageFour = ? WHERE PropertyID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('ssdssssssssssssssi', $title, $description, $price, $address, $city, $state, $zipcode, $propertyType, $status, $garageSpace, $bedrooms, $bathrooms, $squareMeters, $imageOne, $imageTwo, $imageThree, $imageFour, $propertyID);

    if ($updateStmt->execute()) {
        // Redirect back to the individual property page after saving the changes
        header("Location: Individual.php?PropertyID=" . $propertyID);
        exit();
    } else {
        echo "Error: " . $updateStmt->error;
    }
}

// Query to get the property details
$sql = "SELECT * FROM properties WHERE PropertyID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/individual.css">
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
                <li><a href="./Pages/Properties.php">Properties</a></li>
                <li><a href="./Pages/Book.php">Book Agent</a></li>
                <li><a href="../Pages/Morgage.php">Morgage Calculator</a></li>
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'agent'): ?>
                <li><a href="./Pages/AddProperty.php">Add Property</a></li>
            <?php endif; ?>
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'admin'): ?>
                <li><a href="./Pages/AdminApproval.php">Approval</a></li>
            <?php endif; ?>
            </ul>
        </div>
        <a href="../logout.php" class="btn btn-warning">Logout</a>
</nav>

    <div class="header"></div>

    <div class="container">
        <h1>Edit Property</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($property['Title']); ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($property['Description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($property['Price']); ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($property['Address']); ?>">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($property['City']); ?>">
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($property['State']); ?>">
            </div>
            <div class="mb-3">
                <label for="zipcode" class="form-label">Zipcode</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($property['Zipcode']); ?>">
            </div>
            <div class="mb-3">
                <label for="propertyType" class="form-label">Property Type</label>
                <input type="text" class="form-control" id="propertyType" name="propertyType" value="<?php echo htmlspecialchars($property['PropertyType']); ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <div>
                    <input type="radio" id="available" name="status" value="available" <?php if ($property['Status'] == 'available') echo 'checked'; ?>>
                    <label for="available">Available</label>
                    <input type="radio" id="pending" name="status" value="pending" <?php if ($property['Status'] == 'pending') echo 'checked'; ?>>
                    <label for="pending">Pending</label>
                    <input type="radio" id="sold" name="status" value="sold" <?php if ($property['Status'] == 'sold') echo 'checked'; ?>>
                    <label for="sold">Sold</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="garageSpace" class="form-label">Garage Space</label>
                <input type="number" class="form-control" id="garageSpace" name="garageSpace" value="<?php echo htmlspecialchars($property['GarageSpace']); ?>">
            </div>
            <div class="mb-3">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['Bedrooms']); ?>">
            </div>
            <div class="mb-3">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="<?php echo htmlspecialchars($property['Bathrooms']); ?>">
            </div>
            <div class="mb-3">
                <label for="squareMeters" class="form-label">Square Meters</label>
                <input type="number" class="form-control" id="squareMeters" name="squareMeters" value="<?php echo htmlspecialchars($property['SquareMeters']); ?>">
            </div>
            <div class="mb-3">
                <label for="imageOne" class="form-label">Image One URL</label>
                <input type="text" class="form-control" id="imageOne" name="imageOne" value="<?php echo htmlspecialchars($property['ImageOne']); ?>">
            </div>
            <div class="mb-3">
                <label for="imageTwo" class="form-label">Image Two URL</label>
                <input type="text" class="form-control" id="imageTwo" name="imageTwo" value="<?php echo htmlspecialchars($property['ImageTwo']); ?>">
            </div>
            <div class="mb-3">
                <label for="imageThree" class="form-label">Image Three URL</label>
                <input type="text" class="form-control" id="imageThree" name="imageThree" value="<?php echo htmlspecialchars($property['ImageThree']); ?>">
            </div>
            <div class="mb-3">
                <label for="imageFour" class="form-label">Image Four URL</label>
                <input type="text" class="form-control" id="imageFour" name="imageFour" value="<?php echo htmlspecialchars($property['ImageFour']); ?>">
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="Individual.php?PropertyID=<?php echo $propertyID; ?>" class="btn btn-danger">Cancel</a>
            </div>
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
