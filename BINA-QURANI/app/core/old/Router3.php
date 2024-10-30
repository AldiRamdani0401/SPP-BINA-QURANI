<?php

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method, $middleware = [])
    {
        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }

    public function get($route, $controller, $action, $middleware = []): void
    {
        $this->addRoute(route: $route, controller: $controller, action: $action, method: "GET", middleware: $middleware);
    }

    public function post($route, $controller, $action, $middleware = []): void
    {
        $this->addRoute(route: $route, controller: $controller, action: $action, method: "POST", middleware: $middleware);
    }

    public function dispatch(): void
    {
        $uri = strtok(string: $_SERVER['REQUEST_URI'], token: '?');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $route => $routeInfo) {
            if (preg_match(pattern: $this->convertToRegex(route: $route), subject: $uri, matches: $matches)) {
                $controllerName = $routeInfo['controller'];
                $action = $routeInfo['action'];
                $middleware = $routeInfo['middleware'];

                // Memanggil middleware jika ada
                if (!empty($middleware)) {
                    foreach ($middleware as $m) {
                        (new $m())->handle($_SERVER); // Kirim request ke middleware
                    }
                }

                // Memuat file controller
                require __DIR__ . "/../controllers/$controllerName.php";

                // Membuat instance dari controller
                $controller = new $controllerName();

                // Panggil action dengan parameter
                array_shift(array: $matches); // Menghapus elemen pertama yang berisi seluruh string
                $controller->$action(...$matches);
                return;
            }
        }

        $this->handleDefaultRoute();
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

    private function convertToRegex($route): string
    {
        // Mengubah {id} menjadi (\\d+)
        $route = preg_replace(pattern: '/\{(\w+)\}/', replacement: '(\d+)', subject: $route);
        return "#^$route$#"; // Mengembalikan regex lengkap
    }
}
