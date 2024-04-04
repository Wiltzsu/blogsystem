<?php
require "db.php";

// Get the form data
$post_id = $_POST['post_id'];
$author = $_POST['author'];
$content = $_POST['content'];

// Prepare the SQL query
$query = "INSERT INTO comments (post_id, author, content) VALUES (?, ?, ?)";
$statement = $pdo->prepare($query);

// Execute the query
$statement->execute([$post_id, $author, $content]);

// Redirect back to the blog post
header("Location: index.php");
exit;