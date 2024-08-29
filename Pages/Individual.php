<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Get the PropertyID from the URL
$propertyID = $_GET['PropertyID'];

// Query to get the property details including the images
$sql = "SELECT Title, State, Price, Bedrooms, Bathrooms, GarageSpace, SquareMeters, Address, City, ImageOne, ImageTwo, ImageThree, ImageFour FROM properties WHERE PropertyID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

// Initialize availability message
$availabilityMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the property status
    $status = $property['Status'];

    // Determine the message based on the status
    if ($status === 'available') {
        $availabilityMessage = 'This property is available!';
    } elseif ($status === 'pending') {
        $availabilityMessage = 'This property is pending.';
    } elseif ($status === 'sold') {
        $availabilityMessage = 'This property has been sold.';
    } else {
        $availabilityMessage = 'Status is unknown.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Property</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/individual.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar">
        <div class="logo">Logo</div>
        <div class="nav-center">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="./Pages/Properties.php">Properties</a></li>
                <li><a href="./Pages/Book.php">Book Agent</a></li>
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'agent'): ?>
                <li><a href="./Pages/AddProperty.php">Add Property</a></li>
            <?php endif; ?>
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'admin'): ?>
                <li><a href="./Pages/AdminApproval.php">Approval</a></li>
            <?php endif; ?>
            </ul>
        </div>
        <a href="logout.php" class="btn btn-warning">Logout</a>
</nav>

<div class="header">
    <div class="overlay"></div>
    <img src="<?php echo htmlspecialchars($property['ImageOne']); ?>" alt="Property Image" class="property-main-image">
    <div class="header-content">
        <h1><?php echo htmlspecialchars($property['Title']); ?></h1>
        <div class="property-details">
            <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($property['Bedrooms']); ?> Bedrooms</span>
            <span><i class="fas fa-parking"></i> <?php echo htmlspecialchars($property['GarageSpace']); ?> Parkings</span>
            <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['Bathrooms']); ?> Bathrooms</span>
        </div>
        <button class="btn btn-primary">Check for Availability</button>
    </div>
</div>

<div class="container my-4">
    <div class="price-section">
        <h3>Price:</h3>
        <p><?php echo htmlspecialchars($property['Price']); ?></p>
        <div class="icons d-flex justify-content-between">
            <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($property['Bedrooms']); ?> Bedrooms</p>
            <p><i class="fas fa-parking"></i> <?php echo htmlspecialchars($property['GarageSpace']); ?> Parkings</p>
            <p><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['Bathrooms']); ?> Bathrooms</p>
            <p><i class="fas fa-expand-arrows-alt"></i> <?php echo htmlspecialchars($property['SquareMeters']); ?> m²</p>
        </div>
    </div>

    <div class="description-section my-4">
        <p><?php echo htmlspecialchars($property['Address']); ?></p>
        <p><?php echo htmlspecialchars($property['City']); ?></p>
        <p><?php echo htmlspecialchars($property['State']); ?></p>
        <button class="btn btn-link read-more">Read More</button>
    </div>

    <div class="details-section my-4">
        <div class="row">
            <div class="col-md-4"><i class="fas fa-bed"></i> Bedrooms: <?php echo htmlspecialchars($property['Bedrooms']); ?></div>
            <div class="col-md-4"><i class="fas fa-parking"></i> Parking: <?php echo htmlspecialchars($property['GarageSpace']); ?></div>
            <div class="col-md-4"><i class="fas fa-bath"></i> Bathrooms: <?php echo htmlspecialchars($property['Bathrooms']); ?></div>
            <div class="col-md-4"><i class="fas fa-warehouse"></i> Garages: <?php echo htmlspecialchars($property['GarageSpace']); ?></div>
        </div>
    </div>

    <div class="gallery-section my-4">
        <div class="row">
            <!-- Display the images from the database -->
            <?php if (!empty($property['ImageTwo'])): ?>
            <div class="col-md-3">
                <img src="<?php echo htmlspecialchars($property['ImageTwo']); ?>" class="img-fluid" alt="Property Image Two">
            </div>
            <?php endif; ?>

            <?php if (!empty($property['ImageThree'])): ?>
            <div class="col-md-3">
                <img src="<?php echo htmlspecialchars($property['ImageThree']); ?>" class="img-fluid" alt="Property Image Three">
            </div>
            <?php endif; ?>

            <?php if (!empty($property['ImageFour'])): ?>
            <div class="col-md-3">
                <img src="<?php echo htmlspecialchars($property['ImageFour']); ?>" class="img-fluid" alt="Property Image Four">
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<div class="footer">
    <p>Footer</p>
</div>

</body>
</html>
