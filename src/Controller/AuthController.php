<?php
namespace App\Controller;

use App\Config\Database;
use App\Controller\BaseController;
use App\Model\UserModel;

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function login()
    {
        // If the login button is submitted execute this code
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if username and password are provided
            if (empty($password) || empty($password)) {
                echo '<div class="alert alert-danger">Please enter both username and password</div>';
            } else {
                $user = $this->userModel->verifyUser($username, $password);

                // Check if user exists and verify the password
                if ($user && password_verify($password, $user['password'])) {

                    // User found and password is correct, set session variables
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['loggedin'] = true; // Indicate that the user is now logged in

                    // Redirect
                    $this->redirect("index.php");
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Incorrect username or password</div>';
                }
            }
        }
    }
}