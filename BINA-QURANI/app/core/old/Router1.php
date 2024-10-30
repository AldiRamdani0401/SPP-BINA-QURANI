<?php


class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            if (array_key_exists($uri, $this->routes[$method])) {
                $controllerName = $this->routes[$method][$uri]['controller'];
                $action = $this->routes[$method][$uri]['action'];

                // Memuat file controller
                require __DIR__ . "/../controllers/$controllerName.php";

                // Membuat instance dari controller
                $controller = new $controllerName();
                $controller->$action();
                } else {
                    $this->handleDefaultRoute();
                }
            } catch (Exception $e) {
                // Tangani kesalahan di sini, misalnya log atau tampilkan pesan kesalahan
                echo "An error occurred: " . $e->getMessage();
            }
    }

    private function handleDefaultRoute()
    {
        $controllerName = "DefaultController";
        $action = "index";

        // Memuat file controller
        require __DIR__ . "/../controllers/$controllerName.php";

        // Membuat instance dari controller
        $controller = new $controllerName();
        $controller->$action();
    }
}