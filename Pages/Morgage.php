<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
    exit();
}

$monthlyPayment = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loanAmount = $_POST['loanAmount'];
    $interestRate = $_POST['interestRate'] / 100 / 12;
    $loanTerm = $_POST['loanTerm'] * 12;

    // Calculate the monthly payment
    $x = pow(1 + $interestRate, $loanTerm);
    $monthlyPayment = ($loanAmount * $x * $interestRate) / ($x - 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/Morgage.css">

</head>
<body>

<nav class="navbar">
    <div class="logo">
        <a href="#">
            <img src="../Assets/logo.png" alt="Logo" style="height: 60px;">
        </a>
    </div>
    <div class="nav-center">
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../Pages/Properties.php">Properties</a></li>
            <li><a href="../Pages/Book.php">Book Agent</a></li>
            <li><a href="#">Mortgage Calculator</a></li>
            <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'agent'): ?>
            <li><a href="../Pages/AddProperty.php">Add Property</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'admin'): ?>
            <li><a href="../Pages/AdminApproval.php">Approval</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <a href="logout.php" class="btn btn-warning">Logout</a>
</nav>


<div class="mortgage-calculator">
    <h2>Mortgage Calculator</h2>
    <form method="POST">
        <div class="form-group">
            <label for="loanAmount">Loan Amount (R):</label>
            <input type="number" id="loanAmount" name="loanAmount" required>
        </div>
        <div class="form-group">
            <label for="interestRate">Interest Rate (%):</label>
            <input type="number" step="0.01" id="interestRate" name="interestRate" required>
        </div>
        <div class="form-group">
            <label for="loanTerm">Loan Term (Years):</label>
            <input type="number" id="loanTerm" name="loanTerm" required>
        </div>
        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>

    <?php if ($monthlyPayment): ?>
        <div id="result" class="result">
            <?php echo "Estimated Monthly Payment: R" . number_format($monthlyPayment, 2); ?>
        </div>
    <?php endif; ?>
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
