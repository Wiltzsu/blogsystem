<?php
// Include database connection
require "db.php";

// Check if the form for deleting a post has been submitted
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // Prepare SQL query to delete the post with the specified ID
    $query = "DELETE FROM posts WHERE id=:id";
    $delete = $pdo->prepare($query);

    // Bind the parameter and execute the query
    $delete->bindValue(':id', $id, PDO::PARAM_INT);
    $delete->execute();

    // Redirect back to index.php after deletion
    header("Location: index.php");
    exit(); // Ensure script execution stops after redirection
} else {
    // Display a red div indicating that no post ID was provided
    echo '<div style="background-color: red; color: white; padding: 10px;">No post ID provided</div>';
}
?>