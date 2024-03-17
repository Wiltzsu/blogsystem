<?php
// Database connection
require "db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// If the login button is submitted execute this code
if (isset($_POST['submit'])) {
    $username = $_POST['username']; // Store username in a variable
    $password = $_POST['password']; // Store password in a variable

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        echo '<div class="alert alert-danger">Please enter both username and password</div>';
    } else {
        // Prepare and execute a query to retrieve user information based on the provided username
        $login = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $login->execute([$username]);
        // Fetch the result as an associative array
        $user = $login->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];
                // Redirect to the index.php page
                header("Location: index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">Incorrect password</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Username not found</div>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the login form */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card p-4">
                <h2 class="text-center mb-4">Login</h2>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
                    <a href="create_user.php"><p>Create an account</p></a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
