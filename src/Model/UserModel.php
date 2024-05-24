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
}