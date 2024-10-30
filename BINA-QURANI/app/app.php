<?php

require "core/Router.php";
require __DIR__ . "/../app/handlers/ErrorHandler.php";

class App {
    protected $router;

    public function __construct() {
        $errorHandler = new ErrorHandler();
        $this->router = new Router(errorHandler: $errorHandler);
    }

    public function get($route, $controller, $action, $middleware = []) {
        $this->router->get($route, $controller, $action, $middleware);
    }

    public function post($route, $controller, $action, $middleware = []) {
        $this->router->post($route, $controller, $action, $middleware);
    }

    public function run() {
        try {
            $this->router->dispatch();
        } catch (Exception $e) {
            // Handle any other exceptions that are not caught by Router
            echo $e->getMessage();
        }
    }
}
