<?php
require "header.php";

// If the user is not logged in, redirect to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
<body>
    <div class="container">
        <div class="row p-5">
            <div class="col-sm-12">
                <p>Username: <?php echo $username?></p>
                <p>Email: <?php echo $email?></p>
                <button type="button" class="btn btn-info" onclick="location.href='edit_user.php'">Edit</button>
                <button type="button" class="btn btn-info" onclick="location.href='change_user_password.php'">Change password</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>