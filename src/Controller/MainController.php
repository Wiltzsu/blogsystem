<?php
namespace App\Controller;

use App\Model\Authentication;
use App\Model\Blogpost;
use App\Model\User;

class MainController
{
    private $_db;
    private $blogpostModel;


    /**
     * Initializes the main controller with model instances using a database connection
     * @param \PDO $db Database connection
     */
    public function __construct(\PDO $db)
    {
        $this->_db = $db;
        $this->blogpostModel = new Blogpost($this->_db);
    }

    /**
     * Gathers data from models and passes them to the view.
     * Servers as the main entry point for rendering the page for the user.
     */
    public function index()
    {
        $blogposts = $this->blogpostModel->getBlogPosts();
        include __DIR__ . "/../View/main_view.php";
    }
}