<?php
require "db.php";

# SQL query to get blog posts from database
$query = "SELECT id, created_at, title, content FROM posts ORDER BY created_at DESC";
$data = $pdo->query($query);

# Save results to JSON file
$JSON='{"posts":[';
$count = 0;
$rows = $data->rowCount();

# Iterate through rows and append to JSON file
while($row = $data->fetch(PDO::FETCH_ASSOC)) {
    $count++;

    // Correct JSON structure and retrieve content from the row
    $JSON .= '{"id":"' . $row['id'] . '", "created_at":"' . $row['created_at'] . '","title":"' . $row['title'] . '","content":"' . $row['content'] . '"}';
    if ($count < $rows) $JSON .= ","; // Add comma for separating JSON objects
}

# Close JSON file
$JSON .= ']}';

# Write to JSON
$handler = fopen("data.json", "w");
fwrite($handler, $JSON);
fclose($handler);
?>