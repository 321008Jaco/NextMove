<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/registration.css">
</head>
<body>
    <div class="container">
        <form action="Registration.php" method="post">
            <?php
if (isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $userType = $_POST["Type"]; // Corrected variable name

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();

    if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat) OR empty($userType)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password is less than 8 characters");
    }
    if ($password !== $passwordRepeat) {
        array_push($errors, "Password does not match");
    }

    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            array_push($errors, "Email already exists.");
        }
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql = "INSERT INTO users (full_name, email, password, Type) VALUES (?, ?, ?, ?)"; // Updated column name
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $fullName, $email, $passwordHash, $userType); // Corrected binding
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>You are registered successfully!</div>";
        } else {
            die("Something went wrong");
        }
    }
}
            ?>
            <div class="form-group">
                <input type="text" name="fullname" placeholder="Fullname:" class="form-control">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email:" class="form-control">
            </div>

            <!-- User Type Buttons -->
            <div class="form-group user-type-group">
                <label class="user-type-label">Select User Type:</label>
                <div class="user-type-options">
                    <label><input type="radio" name="Type" value="user" required> User</label>
                    <label><input type="radio" name="Type" value="agent" required> Agent</label>
                    <label><input type="radio" name="Type" value="admin" required> Admin</label>
                </div>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password:" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" name="repeat_password" placeholder="Repeat Password:" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Register" name="submit" class="btn btn-primary">
            </div>

            <div class="message"><p>Already have an account? <a href="Login.php">Login Here!</a></p></div>
            
        </form>

        <div class="logo">
            <img src="./Assets/logo.png" alt="Logo">
        </div>
    </div>
</body>
</html>