<?php
namespace Test\Test;

require "db.php";
require "get_users.php"; // Assuming the class file is named get_users.php

// Instantiate the get_users class with the PDO object
$getUsers = new get_users($pdo);

// Call the method to fetch users and convert to JSON
$getUsers->usersToJson();
?>