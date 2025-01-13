<?php

class GeneralController
{
    public function index()
    {
        $path = BASE_PATH . "/views/general/index.php";
        require_once $path;
    }
}
