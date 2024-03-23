<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection file
require "db.php";

// Define variables and initialize with empty values
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Start the session
                session_start();

                // Store data in session variables
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $password;

                // Redirect the user to login page
                header("location: login.php");
                exit();
            } else {
                // Get error information from the prepared statement
                $errorInfo = $stmt->errorInfo();
                echo '<div style="background-color: red; color: white; padding: 10px; text-align: center;">Creation unsuccessful: ' . $errorInfo[2] . '</div>';
            }
        }
    }
}
?>
