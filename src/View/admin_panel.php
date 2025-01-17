<?php 
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if username is set in the session and not empty
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
  
if (isset($_SESSION['loggedin']) && $_SESSION['username'] == 'admin') {
    $username = $_SESSION['username'];
}

?>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
      <h2>List of users</h2>
      <?php
        require "get_users_instance.php";

        $filePath = "users.json";

        // Check if file exists
        if (file_exists($filePath)) {
            // Check if file is readable
            if (is_readable($filePath)) {
                $json_data = file_get_contents($filePath);
                // Decode the JSON data into a PHP array
                $usersArray = json_decode($json_data, true);

                // Check if $usersArray contains 'users' and it is an array
                if (isset($usersArray['users']) && is_array($usersArray['users'])) {
                    // Iterate through each user in the array
                    foreach ($usersArray['users'] as $user) {
                        echo "<div class='user'>";
                        // Display the user information, ensure these keys match your JSON structure
                        echo "<p>ID: " . htmlspecialchars($user['user_id']) . "</p>"; // Display the user ID
                        echo "<p>Username: " . htmlspecialchars($user['username']) . "</p>"; // Display the username
                        echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>"; // Display the email
                        echo "</div>";
                        ?>
                        <!-- Sends a query string with 'user_id' to delete_user to delete the user with the id in the query string -->
                          <button type="button" class="btn btn-secondary" onclick="location.href='delete_user.php?user_id=<?php echo $user['user_id']; ?>'">Delete user from database</button>
                        <?php
                    }
                } else {
                    echo "<p>No user data found in $filePath</p>";
                }
            } else {
                echo "<p>File $filePath exists but is not readable</p>";
            }
        } else {
            echo "<p>File $filePath does not exist</p>";
        }
        ?>
      </div>
    </div>

  </div>
</body>
