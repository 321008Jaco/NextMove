<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
    exit();
}

// Database connection
require_once "../database.php"; // Assuming you have a separate file for database connection

// Initialize variables for filtering
$propertyType = $_GET['property-type'] ?? '';
$bedrooms = $_GET['bedrooms'] ?? '';
$bathrooms = $_GET['bathrooms'] ?? '';
$garageSpace = $_GET['garagespace'] ?? '';
$minPrice = $_GET['min-price'] ?? '0';
$maxPrice = $_GET['max-price'] ?? '25000000';

// Build the SQL query with filtering options
$sql = "SELECT Title, State, Price, Bedrooms, Bathrooms, GarageSpace, SquareMeters, Address, City, ImageOne 
        FROM properties 
        WHERE Price >= $minPrice AND Price <= $maxPrice";

// Add additional filters if provided
if ($propertyType) {
    $sql .= " AND PropertyType = '$propertyType'";
}
if ($bedrooms) {
    $sql .= " AND Bedrooms = '$bedrooms'";
}
if ($bathrooms) {
    $sql .= " AND Bathrooms = '$bathrooms'";
}
if ($garageSpace) {
    $sql .= " AND GarageSpace = '$garageSpace'";
}

$result = mysqli_query($conn, $sql);

// Fetch the properties
$properties = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $properties[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/Properties.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Logo</div>
        <div class="nav-center">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">Properties</a></li>
                <li><a href="/Book.php">Book Agent</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Welcome</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tincidunt nulla ut quam pulvinar, sed congue orci eleifend. Nulla facilisi. Maecenas et facilisis justo.</p>
            <p>Integer imperdiet nibh id metus faucibus, sit amet dictum justo fermentum. Suspendisse potenti. Vivamus euismod fringilla dolor.</p>
        </div>
    </section>

    <section class="filter-section">
        <h2>Filter</h2>
        <form method="GET" action="Properties.php">
            <div class="filters">
                <div class="filter-group">
                    <label for="property-type">Property Type</label>
                    <select id="property-type" name="property-type">
                        <option value="">Any</option>
                        <option value="house" <?= $propertyType == 'house' ? 'selected' : '' ?>>House</option>
                        <option value="apartment" <?= $propertyType == 'apartment' ? 'selected' : '' ?>>Apartment</option>
                        <option value="office" <?= $propertyType == 'office' ? 'selected' : '' ?>>Office</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="bedrooms">Bedrooms</label>
                    <select id="bedrooms" name="bedrooms">
                        <option value="">Any</option>
                        <option value="1" <?= $bedrooms == '1' ? 'selected' : '' ?>>1 Bedroom</option>
                        <option value="2" <?= $bedrooms == '2' ? 'selected' : '' ?>>2 Bedrooms</option>
                        <option value="3" <?= $bedrooms == '3' ? 'selected' : '' ?>>3 Bedrooms</option>
                        <option value="4" <?= $bedrooms == '4' ? 'selected' : '' ?>>4 Bedrooms</option>
                        <option value="5" <?= $bedrooms == '5' ? 'selected' : '' ?>>5 Bedrooms</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="bathrooms">Bathrooms</label>
                    <select id="bathrooms" name="bathrooms">
                        <option value="">Any</option>
                        <option value="1" <?= $bathrooms == '1' ? 'selected' : '' ?>>1 Bathroom</option>
                        <option value="2" <?= $bathrooms == '2' ? 'selected' : '' ?>>2 Bathrooms</option>
                        <option value="3" <?= $bathrooms == '3' ? 'selected' : '' ?>>3 Bathrooms</option>
                        <option value="4" <?= $bathrooms == '4' ? 'selected' : '' ?>>4 Bathrooms</option>
                        <option value="5" <?= $bathrooms == '5' ? 'selected' : '' ?>>5 Bathrooms</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="garagespace">Garage Space</label>
                    <select id="garagespace" name="garagespace">
                        <option value="">Any</option>
                        <option value="1" <?= $garageSpace == '1' ? 'selected' : '' ?>>1 Garage</option>
                        <option value="2" <?= $garageSpace == '2' ? 'selected' : '' ?>>2 Garages</option>
                        <option value="3" <?= $garageSpace == '3' ? 'selected' : '' ?>>3 Garages</option>
                        <option value="4" <?= $garageSpace == '4' ? 'selected' : '' ?>>4 Garages</option>
                        <option value="5" <?= $garageSpace == '5' ? 'selected' : '' ?>>5 Garages</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="min-price">Min: <span id="min-price-value">R<?= number_format($minPrice) ?></span></label>
                    <input type="range" id="min-price" name="min-price" min="0" max="100000000" step="100000" value="<?= $minPrice ?>" oninput="updateMinPrice(this.value)">
                </div>
                <div class="filter-group">
                    <label for="max-price">Max: <span id="max-price-value">R<?= number_format($maxPrice) ?></span></label>
                    <input type="range" id="max-price" name="max-price" min="500000" max="100000000" step="100000" value="<?= $maxPrice ?>" oninput="updateMaxPrice(this.value)">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>
    </section>

    <section class="properties-section">
        <div class="property-grid">
            <?php foreach ($properties as $property): ?>
            <div class="property-card">
                <img src="<?php echo htmlspecialchars($property['ImageOne']); ?>" class="img-fluid" alt="Property Image">
                <div class="card-info">
                    <h3><?php echo htmlspecialchars($property['Title']); ?></h3>
                    <p><?php echo htmlspecialchars($property['State']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($property['Price']); ?></p>
                    <div class="icons">
                        <p><i class="fas fa-bed"></i> <?php echo htmlspecialchars($property['Bedrooms']); ?></p>
                        <p><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['Bathrooms']); ?></p>
                        <p><i class="fas fa-car"></i> <?php echo htmlspecialchars($property['GarageSpace']); ?></p>
                        <p><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($property['SquareMeters']); ?> m²</p>
                        <p><?php echo htmlspecialchars($property['City'] . ', ' . $property['Address']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        Footer Content Here
    </footer>

    <script>
    function updateMinPrice(value) {
        document.getElementById('min-price-value').innerText = `R${parseInt(value).toLocaleString()}`;
    }

    function updateMaxPrice(value) {
        document.getElementById('max-price-value').innerText = `R${parseInt(value).toLocaleString()}`;
    }
    </script>
</body>
</html>
