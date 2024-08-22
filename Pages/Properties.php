<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
    exit();
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
        <div class="filters">
            <div class="filter-group">
                <label for="property-type">House</label>
                <select id="property-type">
                    <option value="house">House</option>
                    <option value="apartment">Apartment</option>
                    <option value="condo">Condo</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="area">Area</label>
                <select id="area">
                    <option value="area1">Area 1</option>
                    <option value="area2">Area 2</option>
                    <option value="area3">Area 3</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="bedrooms">Bedroom</label>
                <select id="bedrooms">
                    <option value="1">1 Bedroom</option>
                    <option value="2">2 Bedrooms</option>
                    <option value="3">3 Bedrooms</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="bathrooms">Bathroom</label>
                <select id="bathrooms">
                    <option value="1">1 Bathroom</option>
                    <option value="2">2 Bathrooms</option>
                    <option value="3">3 Bathrooms</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="min-price">Min: R0</label>
                <input type="range" id="min-price" name="min-price" min="0" max="5000000" step="100000">
            </div>
            <div class="filter-group">
                <label for="max-price">Max: R25 000 000</label>
                <input type="range" id="max-price" name="max-price" min="1000000" max="25000000" step="100000">
            </div>
        </div>
    </section>

    <section class="properties-section">
        <div class="property-grid">
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
            <div class="property-card"></div>
        </div>
    </section>

    <footer>
        Footer Content Here
    </footer>
</body>
</html>
