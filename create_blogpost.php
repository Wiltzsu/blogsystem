<?php
session_start();
// Database connection
require "db.php";

// Check if the form has been submitted
if (isset($_POST['save'])) {
    // Retrieve form data using POST method, only form submitted data comes from POST
    $title=trim($_POST['title']); 
    $content=trim($_POST['content']);

    // Check if user is logged in and has a user id
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page
        header('Location: login.php');
        exit;
    }
    $user_id = $_SESSION['user_id']; // Get the user_id from the session

    try {
        // Check if both title and content are provided
        if ($title && $content) {
            // SQL statement to insert new post into the database
            $sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";

            // Prepare the SQL statement for execution to prevent SQL injection
            $stmt = $pdo->prepare($sql);

            // Execute the prepared statement with the title and content variables
            $stmt->execute([$user_id, $title, $content]);

            // Display success message if the post is created succesfully
            echo "<div class='alert alert-success'>Post created successfully!</div>";

            // Redirect back to index.php after deletion
            header("Location: index.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            // Display error message if the title or content is missing
            echo "<div class='alert alert-danger'>Title and content are required!</div>";
        }
    } catch (Exception $e) {
        // Log the error (prevent exposing sensitive information)
        echo $e;
        echo "<div class=\"alert alert-danger\">An error occurred. Please try again later.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <div class="container">
        <h1>Create New Post</h1>

        <button type="button" class="btn btn-primary" onclick="location.href='index.php'">Go Back</button>

        <form action="create_blogpost.php" method="post">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
            </div>
            
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="3" placeholder="Post content" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="save">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
