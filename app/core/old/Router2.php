<?php


class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method): void
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function get($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], token: '?');
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            foreach ($this->routes[$method] as $route => $params) {
                // Membuat pola regex untuk menangkap parameter
                $pattern = preg_replace(pattern: '/\{(\w+)\}/', replacement: '(\w+)', subject: $route);
                if (preg_match(pattern: "#^$pattern$#", subject: $uri, matches: $matches)) {
                    array_shift(array: $matches); // Menghapus elemen pertama yang merupakan string lengkap
                    $controllerName = $params['controller'];
                    $action = $params['action'];

                    // Memuat file controller
                    require __DIR__ . "/../controllers/$controllerName.php";
                    // Membuat instance dari controller
                    $controller = new $controllerName();
                    // Panggil metode dengan parameter
                    return call_user_func_array(callback: [$controller, $action], args: $matches);
                }
            }
            // Jika tidak ada rute yang cocok, gunakan rute default
            $this->handleDefaultRoute();
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    private function handleDefaultRoute(): void
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