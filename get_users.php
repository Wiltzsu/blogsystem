<?php
require "db.php";

class get_users {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function usersToJson() {
        // SQL query to get the users from database
        $query = "SELECT user_id, username, email FROM users ORDER BY username DESC";
        $data = $pdo->query($query);

        // Fetch all data at once, each row will be an associative array with column name as keys
        $users = $data->fetchAll(PDO::FETCH_ASSOC);

        // Prepare array for JSON encoding
        $jsonData = ['users' => $users];

        // Encode the data from PHP to JSON, PRETTY_PRINT makes the JSON string more readable
        $json = json_encode($jsonData, JSON_PRETTY_PRINT);

        // Write to JSON file, file_put_contents will create the file if it doesn't exist
        file_put_contents("users.json", $json);
    }
}

