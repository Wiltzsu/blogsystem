<?php
namespace App\Model;

use App\Config\Database;
use PDO;

class GetComments
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getPostComments($postId)
    {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}