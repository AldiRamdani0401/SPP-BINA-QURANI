<?php

require "../app/app.php";
require "../app/middleware/AuthMiddleware.php";
require "../app/helpers/url_helper.php";

session_start();

$app = new App();
$app->get(route: '/', controller: 'HomeController', action: 'index');
// $app->get(route: '/home', controller: 'HomeController', action: 'index');
$app->get(route: '/login', controller: 'AuthController', action: 'login');
$app->post(route: '/login', controller: 'AuthController', action: 'loginAction');

// Admin
$app->get(route: '/admin', controller: 'AdminController', action: 'index', middleware: [AuthMiddleware::class]);
$app->get(route: '/admin/{id}', controller: 'AdminController', action: 'show', middleware: [AuthMiddleware::class]);
$app->get(route: '/admin/data-siswa', controller: 'SiswaController', action: 'show', middleware: [AuthMiddleware::class]);
$app->get(route: '/admin/data-siswa/{id}', controller: 'SiswaController', action: 'show', middleware: [AuthMiddleware::class]);

$app->get(route: '/data-siswa', controller: 'SiswaController', action: 'getAllDataSiswa', middleware: [AuthMiddleware::class]);
$app->get(route: '/data-siswa/{id}', controller: 'SiswaController', action: 'getDataSiswa', middleware: [AuthMiddleware::class]);

$app->get(route: '/data-orang-tua', controller: 'OrangTuaController', action: 'getAllDataOrangTua', middleware: [AuthMiddleware::class]);
$app->get(route: '/data-orang-tua/{id}', controller: 'OrangTuaController', action: 'getDataOrangTua', middleware: [AuthMiddleware::class]);

$app->get(route: '/data-kelas', controller: 'KelasController', action: 'getAllDataKelas', middleware: [AuthMiddleware::class]);
$app->get(route: '/data-kelas/{id}', controller: 'KelasController', action: 'getDataKelas', middleware: [AuthMiddleware::class]);

// User
$app->get(route: '/user', controller: 'UserController', action: 'index', middleware: [AuthMiddleware::class]);
$app->get(route: '/user/{id}', controller: 'UserController', action: 'show', middleware: [AuthMiddleware::class]);

$app->run();