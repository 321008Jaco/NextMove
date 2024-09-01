<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
    exit();
}

require_once "../database.php";

// Fetch all agents for the dropdown
$agentsQuery = "SELECT id, full_name FROM users WHERE Type = 'agent'";
$agentsResult = mysqli_query($conn, $agentsQuery);

// Handle form submission
$submitted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $propertyName = $_POST['property_name'];
    $agentID = $_POST['agent'];
    $userID = $_SESSION['user_id'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $comments = $_POST['comments'];

    $sql = "INSERT INTO bookings (AgentID, UserID, Email, PhoneNumber, PropertyName, Date, Time, Comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssss", $agentID, $userID, $email, $phoneNumber, $propertyName, $date, $time, $comments);

    if ($stmt->execute()) {
        $submitted = true;
        header("Location: Book.php"); // Redirect to avoid form resubmission
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch user's bookings
$bookingsQuery = "SELECT b.PropertyName, u.full_name as AgentName, b.Date, b.Time, b.Comments FROM bookings b JOIN users u ON b.AgentID = u.id WHERE b.UserID = ?";
$bookingsStmt = $conn->prepare($bookingsQuery);
$bookingsStmt->bind_param("i", $_SESSION['user_id']);
$bookingsStmt->execute();
$bookings = $bookingsStmt->get_result();

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
    <div class="logo">
        <a href="#">
            <img src="../Assets/Logo.png" alt="Logo" style="height: 60px;">
        </a>
    </div>
    <div class="nav-center">
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../Pages/Properties.php">Properties</a></li>
            <li><a href="#">Book Agent</a></li>
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

<div class="hero-section">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Contact Agent</h1>
    </div>
</div>

<section class="booking-form-section">
    <form class="booking-form" method="POST" action="">
        <h2>Contact Agent</h2>
        <input type="text" name="property_name" placeholder="Property Name" required>
        <div class="form-group">
            <label for="agent">Choose Agent</label>
            <select name="agent" id="agent" required>
                <?php while ($agent = mysqli_fetch_assoc($agentsResult)): ?>
                    <option value="<?php echo $agent['id']; ?>"><?php echo $agent['full_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone_number" placeholder="Phone Number" required>
        <div class="form-group">
            <input type="date" name="date" placeholder="Date" required>
            <input type="time" name="time" placeholder="Time" required>
        </div>
        <textarea name="comments" placeholder="Comments"></textarea>
        <button type="submit" name="submit">Submit</button>
    </form>
</section>

<section class="bookings-section">
    <h2>Your Bookings</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Property Name</th>
                <th>Agent Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['PropertyName']); ?></td>
                    <td><?php echo htmlspecialchars($booking['AgentName']); ?></td>
                    <td><?php echo htmlspecialchars($booking['Date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['Time']); ?></td>
                    <td><?php echo htmlspecialchars($booking['Comments']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

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
