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
    <title>Property Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/propertyDetails.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Elysian Haven</div>
        <div class="nav-center">
            <ul>
                <li><a href="/index.php">Home</a></li>
                <li><a href="./Pages/Properties.php">Properties</a></li>
                <li><a href="/Book.php">Book Agent</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Elysian Haven</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tincidunt nulla ut quam pulvinar, sed congue orci eleifend.</p>
                <p>Nulla facilisi. Maecenas et facilisis justo.</p>
            </div>
        </div>
        <div class="hero-icons">
            <div class="icon-group">
                <div class="icon">7 Guest</div>
                <div class="icon">4 Parkings</div>
                <div class="icon">7 Bathroom</div>
            </div>
            <button class="availability-button">Check for Availability</button>
        </div>
    </section>

    <section class="property-info">
        <div class="price-section">
            <h2>Price:</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tincidunt nulla ut quam.</p>
            <p>Lorem ipsum dolor sit amet</p>
            <p class="highlight">Lorem ipsum dolor sit amet</p>
            <div class="property-icons">
                <div>7 Guest</div>
                <div>4 Parkings</div>
                <div>7 Bathroom</div>
                <div>842 m<sup>2</sup></div>
            </div>
        </div>
        <div class="description">
            <p>Lorem ipsum dolor sit amet.</p>
            <p>Lorem ipsum dolor sit amet.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tincidunt nulla ut quam pulvinar, sed congue orci eleifend.</p>
            <p>+ Read More</p>
        </div>
    </section>

    <section class="amenities-section">
        <div class="amenities-icons">
            <div>Bedrooms: 7</div>
            <div>Parking: 4</div>
            <div>Bathrooms: 7</div>
            <div>Garages: 6</div>
        </div>
    </section>

    <section class="gallery-section">
        <div class="gallery-grid">
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
            <div class="gallery-item"></div>
        </div>
    </section>

    <footer class="footer">
        Footer Content Here
    </footer>
</body>
</html>
