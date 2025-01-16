<?php

require_once realpath(dirname(__DIR__) . '/app/App.php');

// Base path: Menggunakan realpath untuk memastikan path absolut yang benar
define('BASE_PATH', realpath(dirname(__DIR__) . '/app'));

session_start();
$app = new App();
