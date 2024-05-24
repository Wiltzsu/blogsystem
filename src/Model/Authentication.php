<?php
namespace App\Model;

use App\Config\Database;
use PDO;

class Authentication
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function userSession()
    {
        // Check if username is set in the session and *not empty*
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }
    }

    public function logoutUser()
    {
        // Unset all session variables
        $_SESSION = array();

        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to home page
        header("Location: index.php");
        exit;

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

    public function registerUser($param_username, $param_email, $param_password)
    {
        $username = $email = $password = "";
        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate username
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Validate email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        // Check input errors before inserting into database
        if (empty($username_err) && empty($email_err) && empty($password_err)) {
            // Prepare an insert statement
    
        }

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        if ($stmt = $this->db->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $hashedPassword;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Start the session
                session_start();

                // Store data in session variables
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;

                // Redirect the user to login page
                header("location: login.php");
                exit();
            } else {
                // Get error information from the prepared statement
                $errorInfo = $stmt->errorInfo();
                echo '<div style="background-color: red; color: white; padding: 10px; text-align: center;">Creation unsuccessful: ' . $errorInfo[2] . '</div>';
            }
        }
    }
}

}