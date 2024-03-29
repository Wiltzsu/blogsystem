<?php
require "header.php";

// Get user_id from the session and save it to a variable
$userid = $_SESSION['user_id'];
// Fetch all user information from database
$query = "SELECT * FROM users WHERE user_id = :user_id";
// Prepare the statement
$statement = $pdo->prepare($query);
// Bind a value to :user_id placeholder
$statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
// Execute the statement
$statement->execute();
// Fetch the result in an associative array
$result = $statement->fetch(PDO::FETCH_ASSOC);

// Assign the user values to variables
$user_id = $result['user_id'];
$username = $result['username'];
$password = $result['password'];
$email = $result['email'];
?>

<div class="container">
    <div class="row p-5">
        <div class="col-sm-12">
            <p>ID: <?php echo $user_id?></p>
            <p>Username: <?php echo $username?></p>
            <p>Password: <?php echo $password?></p>
            <p>Email: <?php echo $email?></p>
            <button type="button" class="btn btn-info" onclick="location.href='edit_user.php'">Edit</button>
        </div>
    </div>
</div>