<?php
class AdminController
{
    public function index()
    {
        $path = BASE_PATH . "/views/admin/index.php";
        require_once $path;
    }
}
