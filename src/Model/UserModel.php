<?php
namespace App\Model;

use App\Config\Database;
use PDO;

class UserModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getUserByUsername($username)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyUser($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user && password_verify($password, $user['password']))
        {
            return $user;
        }
        return null;
    }

    public function getAllUsers()
    {
        // SQL query to get the users from database
        $query = "SELECT user_id, username, email FROM users ORDER BY username DESC";
        $data = $this->db->query($query);

        // Fetch all data at once, each row will be an associative array with column name as keys
        return $data->fetchAll(\PDO::FETCH_ASSOC);  // Use backslash before global class to search for it in global namespace
    }
}