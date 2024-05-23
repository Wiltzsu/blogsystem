<?php
class BaseController {
    public function __construct()
    {
        $this->startSession();
    }

    protected function startSession()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}