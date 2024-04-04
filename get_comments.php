<?php
require "db.php";

// Fetch the blog post's comment from database
function getComments($pdo, $postId) {
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
    $stmt->execute([$postId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}