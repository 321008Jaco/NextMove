<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
    exit();
}



// Database connection
require_once "database.php"; // Assuming you have a separate file for database connection

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get the first 3 properties
$sql = "SELECT PropertyID, Title, State, Price, Bedrooms, Bathrooms, GarageSpace, SquareMeters, Address, City, ImageOne FROM properties WHERE PropertyID IN (1, 2, 3)";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the properties
$properties = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $properties[] = $row;
    }
} else {
    echo "<div class='alert alert-warning'>No properties found</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/index.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <a href="#">
            <img src="./Assets/logo.png" alt="Logo" style="height: 60px;">
        </a>
    </div>
    <div class="nav-center">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="./Pages/Properties.php">Properties</a></li>
            <li><a href="./Pages/Book.php">Book Agent</a></li>
            <li><a href="./Pages/Morgage.php">Morgage Calculator</a></li>
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

<div class="hero-section">
    <div class="overlay"></div>
    <div class="hero-content">
            <h1>Welcome</h1>
            <p>Welcome to NextMove, where your dream home awaits. We are dedicated to helping you find the perfect property that suits your lifestyle and needs, with a wide range of options and expert guidance every step of the way.</p>

        </div>
</div>

<div class="ceo">
    <div class="ceo-contain">
        <h1>Richard Thompson</h1>
        <p>Richard Thompson is a visionary leader with over 20 years of experience in the real estate industry. As the CEO of NextMove, he has transformed the company into a leading force in luxury property development, focusing on delivering dream homes with exceptional quality and design.</p>
        <p>Under Richard's leadership, NextMove continues to set new standards in real estate, making it the go-to choice for discerning homeowners.</p>
    </div>
</div>
<div class="ceo-img">
    <img src="./Assets/Ceo.jpg" alt="Profile Image">
</div>

<div class="profile-section">
    <div>
        <h2>What Are You Looking For?</h2>
    </div>
    <div class="d-flex justify-content-between mt-4">
        <div class="img-button">
            <img src="./Assets/Home.jpg" alt="Option 1" class="img-box rounded">
            <p>Homes</p>
        </div>
        <div class="img-button">
            <img src="./Assets/Apartment.jpg" alt="Option 2" class="img-box rounded">
            <p>Apartments</p>
        </div>
        <div class="img-button">
            <img src="./Assets/Office.jpg" alt="Option 3" class="img-box rounded">
            <p>Offices</p>
        </div>
    </div>
</div>

<div class="showroom-section">
    <div class="container">
        <h2>View Our Showroom</h2>
        <div class="row">
            <?php if (!empty($properties)): ?>
            <?php foreach ($properties as $property): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($property['ImageOne']); ?>" class="img-fluid" alt="Showroom Image">
                    <div class="card-info">
                        <h3><?php echo htmlspecialchars($property['Title']); ?></h3>
                        <p><?php echo htmlspecialchars($property['State']); ?></p>
                        <p>Price: <?php echo htmlspecialchars($property['Price']); ?></p>
                        <div class="icons d-flex justify-content-between">
                            <p><i class="fas fa-bed"></i> <?php echo htmlspecialchars($property['Bedrooms']); ?></p>
                            <p><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['Bathrooms']); ?></p>
                            <p><i class="fas fa-car"></i> <?php echo htmlspecialchars($property['GarageSpace']); ?></p>
                            <p><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($property['SquareMeters']); ?> m²</p>
                        </div>
                        <p><?php echo htmlspecialchars($property['City'] . ', ' . $property['Address']); ?></p>
                        
                        <!-- Add a button linking to the Individual.php page -->
                        <div class="text-center mt-3">
                        <a href="./Pages/Individual.php?PropertyID=<?php echo htmlspecialchars($property['PropertyID']); ?>" class="btn btn-primary">View Details</a>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <p>No properties found.</p>
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