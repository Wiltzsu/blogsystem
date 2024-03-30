<?php
require "db.php";
include "header.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Get used id from the session
    $user_id = $_SESSION['user_id'];

    // Fetch the current password from the database
    $statement = $pdo->prepare("SELECT password FROM users WHERE user_id = :user_id");
    $statement->bindParam(':user_id', $user_id);
    $statement->execute();
    $user = $statement->fetch();

    // Verify the current password
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
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form method="POST" action="change_user_password.php" class="form-container">

                    <div class="form-group">
                        <label for="current_password">Current Password:</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
