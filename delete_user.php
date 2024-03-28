<?php
// Include database connection
require "db.php";

// Check if user_id is provided in the query string
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    // Prepare SQL query to delete the user with the specified ID
    $query = "DELETE FROM users WHERE user_id=:user_id";
    $delete = $pdo->prepare($query);

    // Bind the parameter and execute the query
    $delete->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $delete->execute();

    // Redirect back to index.php after deletion
    header("Location: admin_panel.php");
    exit(); // Ensure script execution stops after redirection
} else {
    // Display a red div indicating that no post ID was provided
    echo '<div style="background-color: red; color: white; padding: 10px;">User not found</div>';
}
?>