<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

require_once "../database.php";

// Get the PropertyID from the URL
$propertyID = $_GET['PropertyID'];

// Query to get the property details including the images and status
$sql = "SELECT Title, State, Price, Bedrooms, Bathrooms, GarageSpace, SquareMeters, Address, City, ImageOne, ImageTwo, ImageThree, ImageFour, Status FROM properties WHERE PropertyID = ?";
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

// Query to get reviews for the property
$reviewSql = "SELECT ReviewText, full_name, Time, Rating FROM review JOIN users ON review.id = users.id WHERE review.property_id = ? ORDER BY Time DESC";
$reviewStmt = $conn->prepare($reviewSql);
$reviewStmt->bind_param("i", $propertyID);
$reviewStmt->execute();
$reviews = $reviewStmt->get_result();
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
                <li><a href="../Pages/Morgage.php">Morgage Calculator</a></li>
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
        <form method="POST" style="display: inline-block;">
            <button type="submit" class="btn btn-primary">Check for Availability</button>
        </form>
        <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'admin'): ?>
        <form method="GET" action="../Pages/EditProperty.php" style="display: inline-block;">
            <input type="hidden" name="PropertyID" value="<?php echo $propertyID; ?>">
            <button type="submit" class="btn btn-secondary">Edit Property</button>
        </form>
    <?php endif; ?>
    <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'user'): ?>
        <form method="GET" action="../Pages/BuyProperty.php" style="display: inline-block;">
            <input type="hidden" name="PropertyID" value="<?php echo $propertyID; ?>">
            <button type="submit" class="btn btn-secondary">Buy Property</button>
        </form>
    <?php endif; ?>
    </div>
    </div>
</div>

<div class="container my-4">
    <!-- Display the availability message if the form has been submitted -->
    <?php if ($availabilityMessage): ?>
        <div class="alert alert-info">
            <?php echo $availabilityMessage; ?>
        </div>
    <?php endif; ?>

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

    <div class="reviews-section my-4">
        <h3>Reviews:</h3>
        <!-- Display existing reviews -->
        <?php while ($review = $reviews->fetch_assoc()): ?>
            <div class="review">
                <p><strong><?php echo htmlspecialchars($review['full_name']); ?></strong> (<?php echo $review['Time']; ?>)</p>
                <p><?php echo htmlspecialchars($review['ReviewText']); ?></p>
                <p>
                    <?php
                    // Display the stars based on the rating
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $review['Rating']) {
                            echo '★'; // Filled star
                        } else {
                            echo '☆'; // Empty star
                        }
                    }
                    ?>
                </p>
            </div>
            <hr>
        <?php endwhile; ?>

        <!-- Form to submit a new review -->
        <form method="POST" action="AddReview.php" class="mt-4">
            <div class="rating">
                <label>
                    <input type="radio" name="rating" value="1"> ★
                </label>
                <label>
                    <input type="radio" name="rating" value="2"> ★★
                </label>
                <label>
                    <input type="radio" name="rating" value="3"> ★★★
                </label>
                <label>
                    <input type="radio" name="rating" value="4"> ★★★★
                </label>
                <label>
                    <input type="radio" name="rating" value="5"> ★★★★★
                </label>
            </div>
            <div class="mb-3">
                <label for="reviewText" class="form-label">Add a Review:</label>
                <textarea class="form-control" id="reviewText" name="reviewText" rows="3" required></textarea>
            </div>
            <input type="hidden" name="propertyID" value="<?php echo $propertyID; ?>">
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
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
