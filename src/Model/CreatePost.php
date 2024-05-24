<?php
namespace App\Model;

use App\Config\Database;
use Exception;

class CreatePost 
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createBlogPost()
    {
   
    // Check if the form has been submitted
    if (isset($_POST['save'])) {
        // Retrieve form data using POST method, only form submitted data comes from POST
        $title=trim($_POST['title']); 
        $content=trim($_POST['content']);
    
        // Check if user is logged in and has a user id
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page
            header('Location: login.php');
            exit;
        }
        $user_id = $_SESSION['user_id']; // Get the user_id from the session
    
        try {
            // Check if both title and content are provided
            if ($title && $content) {
                // SQL statement to insert new post into the database
                $sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    
                // Prepare the SQL statement for execution to prevent SQL injection
                $stmt = $this->db->prepare($sql);
    
                // Execute the prepared statement with the title and content variables
                $stmt->execute([$user_id, $title, $content]);
    
                // Display success message if the post is created succesfully
                echo "<div class='alert alert-success'>Post created successfully!</div>";
    
                // Redirect back to index.php after deletion
                header("Location: index.php");
                exit(); // Ensure script execution stops after redirection
            } else {
                // Display error message if the title or content is missing
                echo "<div class='alert alert-danger'>Title and content are required!</div>";
            }
        } catch (Exception $e) {
            // Log the error (prevent exposing sensitive information)
            echo $e;
            echo "<div class=\"alert alert-danger\">An error occurred. Please try again later.</div>";
        }
    }
    }
 
}

?>