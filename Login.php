<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/login.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    // Store user type in session
                    $_SESSION["user_name"] = $user["full_name"];
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user"] = $user["Type"];
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <form action="Login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login">
            </div>

            <div><p>Don't have an account? <a href="Registration.php">Register Here!</a></p></div>

        </form>

        <div class="logo">
            <img src="./Assets/logo.png" alt="Logo"> <!-- Replace with the correct path to your logo image -->
        </div>

    </div>
</body>
</html>
