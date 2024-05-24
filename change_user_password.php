<?php
require "db.php";
require "header.php";

// If the user is not logged in, redirect to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form values
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Get usedrid from the session
    $user_id = $_SESSION['user_id'];

    // Fetch the current password from the database
    $statement = $pdo->prepare("SELECT password FROM users WHERE user_id = :user_id");
    $statement->bindParam(':user_id', $user_id);
    $statement->execute();
    $user = $statement->fetch();

    // Verify the current password, compare the password from the form with the password from the database
    if (password_verify($current_password, $user['password'])) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Update the password in the database
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            // Update statement to update the password in the database
            $updateStatement = $pdo->prepare("UPDATE users SET password = :new_password WHERE user_id = :user_id");
            // Bind the new hashed password to the :new_password placeholder in the SQL update statement
            $updateStatement->bindParam(':new_password', $new_password_hash);
            // Bind the user id to :user_id placeholder
            $updateStatement->bindParam(':user_id', $user_id);
            // Execute the statement
            $updateStatement->execute();

            echo "Password changed successfully.";
        } else {
            echo "New passwords do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }
}
?>

