<?php 
// Start the session
session_start();
// Database connection
require "db.php";

// Check if username is set in the session and *not empty*
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>


      <li class="nav-item">
                        <span class="nav-link">
                            <?php
                            // Start the session if not already started
                            if (session_status() === PHP_SESSION_NONE) {
                                session_start();
                            }
                            // Check if the session variable exists and display it
                            if (isset($_SESSION['username'])) {
                                echo "Welcome, " . htmlspecialchars($_SESSION['username']);
                            } else {
                                echo "Not logged in";
                            }
                            ?>
                        </span>
                    </li>


      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
