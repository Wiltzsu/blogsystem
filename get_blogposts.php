<?php
require "db.php";

# SQL query to get blog posts from database
$query = "SELECT id, posts.user_id, created_at, title, content, username 
FROM posts 
INNER JOIN users ON posts.user_id = users.user_id
ORDER BY created_at DESC";
$data = $pdo->query($query);

# Save results to JSON file
$JSON='{"posts":[';
$count = 0;
$rows = $data->rowCount();

# Iterate through rows and append to JSON file
while($row = $data->fetch(PDO::FETCH_ASSOC)) {
    $count++;

    // Correct JSON structure and retrieve content from the row
    $JSON .= '{"id":"' . $row['id'] . '", "user_id":"' . $row['user_id'] . '", "created_at":"' . $row['created_at'] . '","title":"' . $row['title'] . '","content":"' . $row['content'] . '","username":"' . $row['username'] . '"}';
    if ($count < $rows) $JSON .= ","; // Add comma for separating JSON objects
}

# Close JSON file
$JSON .= ']}';

# Write to JSON
$handler = fopen("data.json", "w");
fwrite($handler, $JSON);
fclose($handler);
?>