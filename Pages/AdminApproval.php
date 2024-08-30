<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Login.php");
    exit();
}

// Database connection
require_once "../database.php"; // Assuming you have a separate file for database connection

// Handle approval or rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pendingID = $_POST['pendingID'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        // Fetch the property details from the pendingproperties table
        $sql = "SELECT * FROM pendingproperties WHERE PendingID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $pendingID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $property = mysqli_fetch_assoc($result);

        if ($property) {
            // Insert the property into the properties table
            $insert_sql = "INSERT INTO properties (Title, Description, Price, Address, City, State, Zipcode, PropertyType, Status, AgentID, UserID, GarageSpace, Bedrooms, Bathrooms, SquareMeters, ImageOne, ImageTwo, ImageThree, ImageFour) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'available', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt, 'ssdsdsssiiiiissiii',
                $property['Title'],
                $property['Description'],
                $property['Price'],
                $property['Address'],
                $property['City'],
                $property['State'],
                $property['Zipcode'],
                $property['PropertyType'],
                $property['AgentID'],
                $property['UserID'],
                $property['GarageSpace'],
                $property['Bedrooms'],
                $property['Bathrooms'],
                $property['SquareMeters'],
                $property['ImageOne'],
                $property['ImageTwo'],
                $property['ImageThree'],
                $property['ImageFour']
            );
            mysqli_stmt_execute($stmt);

            // Delete the property from pendingproperties after approval
            $delete_sql = "DELETE FROM pendingproperties WHERE PendingID = ?";
            $stmt = mysqli_prepare($conn, $delete_sql);
            mysqli_stmt_bind_param($stmt, 'i', $pendingID);
            mysqli_stmt_execute($stmt);
        }
    } elseif ($action === 'reject') {
        // Reject the property by updating the status
        $sql = "UPDATE pendingproperties SET Status = 'rejected' WHERE PendingID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $pendingID);
        mysqli_stmt_execute($stmt);
    }
}

// Fetch all pending properties
$sql = "SELECT * FROM pendingproperties WHERE Status = 'pending'";
$result = mysqli_query($conn, $sql);

$pendingProperties = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pendingProperties[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/AdminApproval.css"> <!-- Add your admin-specific CSS file here -->
</head>
<body>

    <nav class="navbar">
            <div class="logo">Logo</div>
            <div class="nav-center">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../Pages/Properties.php">Properties</a></li>
                    <li><a href="../Pages/Book.php">Book Agent</a></li>
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'agent'): ?>
                    <li><a href="./Pages/AddProperty.php">Add Property</a></li>
                <?php endif; ?>
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"] === 'admin'): ?>
                    <li><a href="./Pages/AdminApproval.php">Approval</a></li>
                <?php endif; ?>
                </ul>
            </div>
            <a href="../logout.php" class="btn btn-warning">Logout</a>
    </nav>

    <div class="header"></div>

    <div class="container">
        <h1>Pending Property Approvals</h1>

        <?php if (empty($pendingProperties)): ?>
            <p>No pending properties to review.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zipcode</th>
                            <th>Property Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingProperties as $property): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($property['Title']); ?></td>
                                <td><?php echo htmlspecialchars($property['Description']); ?></td>
                                <td><?php echo htmlspecialchars($property['Price']); ?></td>
                                <td><?php echo htmlspecialchars($property['Address']); ?></td>
                                <td><?php echo htmlspecialchars($property['City']); ?></td>
                                <td><?php echo htmlspecialchars($property['State']); ?></td>
                                <td><?php echo htmlspecialchars($property['Zipcode']); ?></td>
                                <td><?php echo htmlspecialchars($property['PropertyType']); ?></td>
                                <td>
                                    <form method="POST" action="AdminApproval.php" style="display: inline-block;">
                                        <input type="hidden" name="pendingID" value="<?php echo $property['PendingID']; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="AdminApproval.php" style="display: inline-block;">
                                        <input type="hidden" name="pendingID" value="<?php echo $property['PendingID']; ?>">
                                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
