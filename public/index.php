<?php
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\MainController;
use App\Config\Database;

$db = Database::connect();

$mainController = new MainController($db);
$mainController->index();