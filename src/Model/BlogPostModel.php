<?php
namespace App\Model;

use App\Config\Database;
use PDO;
use Exception;

class BlogPostModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createBlogPost()
    {
        // Check if the form has been submitted
        if (isset($_POST['save'])) 
        {
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

    public function deleteBlogPost() 
    {
        // Check if the form for deleting a post has been submitted
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            // Prepare SQL query to delete the post with the specified ID
            $query = "DELETE FROM posts WHERE id=:id";
            $delete = $this->db->prepare($query);

            // Bind the parameter and execute the query
            $delete->bindValue(':id', $id, PDO::PARAM_INT);
            $delete->execute();

            // Redirect back to index.php after deletion
            header("Location: index.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            // Display a red div indicating that no post ID was provided
            echo '<div style="background-color: red; color: white; padding: 10px;">No post ID provided</div>';
        }
    }

    public function getBlogPosts()
    {
        # SQL query to get blog posts from database
        $query = "SELECT id, posts.user_id, created_at, title, content, username 
        FROM posts 
        INNER JOIN users ON posts.user_id = users.user_id
        ORDER BY created_at DESC";
        $data = $this->db->query($query);
    }

    public function updateBlogPost()
    {
        try {
            // Retrieve the value of the 'id' parameter from the URL query string
            $id = $_GET['id'];
        
            // Construct the SQL query to select the post based on the provided id
            $query = "SELECT * FROM posts WHERE id = '$id'";
        
            // Execute the SQL query
            $data = $this->db->query($query);
        
            // Fetch the result as an object
            $rows = $data->fetch(PDO::FETCH_OBJ);
        
            // Check if the post with the given id exists
            if ($rows) {
                // Extract the current title and content from the fetched object
                $current_title = $rows->title;
                $current_content = $rows->content;
        
                // Check if the 'update' form has been submitted
                if (isset($_POST['update'])) {
                    // Retrieve the new title and content from the form
                    $new_title = $_POST['title'];
                    $new_content = $_POST['content'];
        
                    // Construct the SQL update to update values in the database
                    $update = "UPDATE posts SET title = :new_title, content = :new_content WHERE id = :id";
                    
                    // Prepare the SQL update statement
                    $updateStatement = $this->db->prepare($update);
        
                    // Bind the new title, content and post id parameters to the statement
                    $updateStatement->bindParam(':new_title', $new_title);
                    $updateStatement->bindParam(':new_content', $new_content);
                    $updateStatement->bindParam(':id', $id); // Add parameter for id
        
                    // Execute the preprared statement which updates the post in the database
                    $updateStatement->execute();
        
                    // Redirect back to index.php after deletion
                    header("Location: index.php");
                    exit(); // Ensure script execution stops after redirection
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function submitComment()
    {
        // Get the form data
        $post_id = $_POST['post_id'];
        $author = $_POST['author'];
        $content = $_POST['content'];

        // Prepare the SQL query
        $query = "INSERT INTO comments (post_id, author, content) VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);

        // Execute the query
        $statement->execute([$post_id, $author, $content]);

        // Redirect back to the blog post
        header("Location: index.php");
        exit;
    }
}