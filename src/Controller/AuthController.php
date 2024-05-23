<?php
require '../Config/Database.php';
class AuthController extends BaseController
{
    public function login($username, $password)
    {
        // If the login button is submitted execute this code
        if (isset($_POST['submit'])) {
            $form_username = $_POST['username']; // Store username from the form in a variable
            $form_password = $_POST['password']; // Likewise the password

            // Check if username and password are provided
            if (empty($form_username) || empty($form_password)) {
                echo '<div class="alert alert-danger">Please enter both username and password</div>';
            } else {
                // Retrieve the users data from the database
                $query = $db->prepare("SELECT * FROM users WHERE username = ?");
                $query->execute([$form_username]);
                $user = $query->fetch(PDO::FETCH_ASSOC);

                // Check if user exists and verify the password
                if ($user && password_verify($form_password, $user['password'])) {

                    // User found and password is correct, set session variables
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['loggedin'] = true; // Indicate that the user is now logged in

                    // Redirect to index.php
                    header("Location: index.php");
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Incorrect username or password</div>';
                }
            }
        }
    }
}