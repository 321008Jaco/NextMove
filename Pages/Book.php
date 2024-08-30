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
    <title>Book Your Agent</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/Book.css">
</head>
<body>
<nav class="navbar">
        <div class="logo">Logo</div>
        <div class="nav-center">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Pages/Properties.php">Properties</a></li>
                <li><a href="#">Book Agent</a></li>
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

    <section class="booking-header">
        <div class="header-left">
            <h1>Book Your Agent!</h1>
        </div>
        <div class="header-right">
            <p>Fill out the form below to book your agent for the selected property and we will be in touch.</p>
        </div>
    </section>

    <section class="booking-form-section">
        <form class="booking-form">
            <h2>Contact Agent</h2>
            <input type="text" placeholder="Name & Surname" required>
            <input type="email" placeholder="Email" required>
            <input type="tel" placeholder="Phone Number" required>
            <input type="text" placeholder="Property Name" required>
            <div class="form-group">
                <input type="date" placeholder="00/00" class="date-input" required>
                <input type="time" placeholder="00:00" class="time-input" required>
            </div>
            <textarea placeholder="Comments"></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>

    <footer class="footer">
        Footer Content Here
    </footer>
</body>
</html>
