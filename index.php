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
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/index.css">
</head>
<body>
<nav class="navbar">
        <div class="logo">Logo</div>
        <div class="nav-center">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="./Pages/Properties.php">Properties</a></li>
                <li><a href="./Pages/Book.php">Book Agent</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </nav>

    <div class="hero-section">
        <div class="overlay"></div>
        <div class="content"></div>
    </div>

            <div class="ceo">
                <div class="ceo-contain">
                <h1>Richard Thompson</h1>
                <p>Richard Thompson is a visionary leader with over 20 years of experience in the real estate industry. As the CEO of Elysian Haven, he has transformed the company into a leading force in luxury property development, focusing on delivering dream homes with exceptional quality and design.</p>
                <p>Under Richard's leadership, Elysian Haven continues to set new standards in real estate, making it the go-to choice for discerning homeowners.</p>
                </div>
            </div>
            <div class="ceo-img">
                <img src="./Assets/Ceo.jpg" alt="Profile Image">
            </div>

    <div class="profile-section">
        <div>
            <h2>Tell us about your dream home</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/showroom/image1.jpg" class="img-fluid" alt="Showroom Image 1">
                    <div class="card-info">
                        <h3>Title</h3>
                        <p>State</p>
                        <p>Price:</p>
                        <div class="icons">
                            <i class="bed-icon"></i>
                            <i class="bath-icon"></i>
                            <p>City & Address</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/showroom/image2.jpg" class="img-fluid" alt="Showroom Image 2">
                    <div class="card-info">
                        <h3>Title</h3>
                        <p>State</p>
                        <p>Price:</p>
                        <div class="icons">
                            <i class="bed-icon"></i>
                            <i class="bath-icon"></i>
                            <p>City & Address</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/showroom/image3.jpg" class="img-fluid" alt="Showroom Image 3">
                    <div class="card-info">
                        <h3>Title</h3>
                        <p>State</p>
                        <p>Price:</p>
                        <div class="icons">
                            <i class="bed-icon"></i>
                            <i class="bath-icon"></i>
                            <p>City & Address</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="footer">
        <p>Footer</p>
    </div>
</body>
</html>
