<?php
namespace App\Model;

use App\Config\Database;
use PDO;

class User {
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllUsers()
    {
        // SQL query to get the users from database
        $query = "SELECT user_id, username, email FROM users ORDER BY username DESC";
        $data = $this->db->query($query);

        // Fetch all data at once, each row will be an associative array with column name as keys
        return $data->fetchAll(\PDO::FETCH_ASSOC);  // Use backslash before global class to search for it in global namespace
    }

    public function deleteUser()
    {
        // Check if user_id is provided in the query string
        if(isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            
            // Prepare SQL query to delete the user with the specified ID
            $query = "DELETE FROM users WHERE user_id=:user_id";
            $delete = $this->db->prepare($query);

            // Bind the parameter and execute the query
            $delete->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $delete->execute();

            // Redirect back to index.php after deletion
            header("Location: admin_panel.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            // Display a red div indicating that no post ID was provided
            echo '<div style="background-color: red; color: white; padding: 10px;">User not found</div>';
        }
    }

    public function showUserInfo()
    {
        // Get user_id from the session and save it to a variable
        $userid = $_SESSION['user_id'];

        // Fetch all user information from database
        $query = "SELECT * FROM users WHERE user_id = :user_id";

        // Prepare the statement
        $statement = $this->db->prepare($query);

        // Bind a value to :user_id placeholder
        $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);

        // Execute the statement
        $statement->execute();

        // Fetch the result in an associative array
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Assign the user values to variables
        $user_id = $result['user_id'];
        $username = $result['username'];
        $password = $result['password'];
        $email = $result['email'];
    }

    public function editUser()
    {
        // Get user id from session to be used in search query
        $user_id = $_SESSION['user_id'];
        // Query the database
        $query = "SELECT username, email FROM users WHERE user_id = '$user_id'";
        // Execute the query and return the result set as a PDOstatement object
        $data = $this->db->query($query);
        // Fetch the next row as an object
        $rows = $data->fetch(PDO::FETCH_OBJ);
    
        // If there are any rows found, set the current values to variables
        if ($rows) {
            $current_username = $rows->username;
            $current_email = $rows->email;
    
            // If 'send' is clicked in the form, update values in the database
            if (isset($_POST['send'])) {
                //$new_user_id = $_POST['user_id'];
                $new_username = $_POST['username'];
                //$new_password = $_POST['password'];
                $new_email = $_POST['email'];
    
                $update = "UPDATE users
                            SET username = :new_username, 
                            email = :new_email
                            WHERE user_id = :current_user_id";
    
                // Prepare the update statement
                $updateStatement = $this->db->prepare($update);
    
                // Bind parameters to values
                $updateStatement->bindParam(':new_username', $new_username);
                $updateStatement->bindParam(':new_email', $new_email);
                $updateStatement->bindParam(':current_user_id', $user_id);
    
                // Execute the update
                $updateStatement->execute();
            }
        }
    }

    public function changePassword()
    {
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the submitted form values
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Get usedrid from the session
            $user_id = $_SESSION['user_id'];

            // Fetch the current password from the database
            $statement = $this->db->prepare("SELECT password FROM users WHERE user_id = :user_id");
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
            $user = $statement->fetch();

            // Verify the current password, compare the password from the form with the password from the database
            if (password_verify($current_password, $user['password'])) {
                // Check if new password and confirm password match
                if ($new_password === $confirm_password) {
                    // Update the password in the database
                    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    // Update statement to update the password in the database
                    $updateStatement = $this->db->prepare("UPDATE users SET password = :new_password WHERE user_id = :user_id");
                    // Bind the new hashed password to the :new_password placeholder in the SQL update statement
                    $updateStatement->bindParam(':new_password', $new_password_hash);
                    // Bind the user id to :user_id placeholder
                    $updateStatement->bindParam(':user_id', $user_id);
                    // Execute the statement
                    $updateStatement->execute();

                    echo "Password changed successfully.";
                } else {
                    echo "New passwords do not match.";
                }
            } else {
                echo "Current password is incorrect.";
            }
        }
    }
}