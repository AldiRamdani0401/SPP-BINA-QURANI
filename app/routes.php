<?php

class Routes
{
    private $routes = [];

    /**
     * Method untuk menambahkan rute GET.
     *
     * @param string $path URL path.
     * @param string $action Controller dan method dalam format "Controller@method".
     * @param bool $middleware Apakah middleware diaktifkan untuk rute ini.
     */
    public function get($path, $action, $middleware = false)
    {
        $this->addRoute('GET', $path, $action, $middleware);
    }

    /**
     * Method untuk menambahkan rute POST.
     *
     * @param string $path URL path.
     * @param string $action Controller dan method dalam format "Controller@method".
     * @param bool $middleware Apakah middleware diaktifkan untuk rute ini.
     */
    public function post($path, $action, $middleware = false)
    {
        $this->addRoute('POST', $path, $action, $middleware);
    }

    /**
     * Method untuk menambahkan rute ke array routes.
     *
     * @param string $method HTTP method.
     * @param string $path URL path.
     * @param string $action Controller dan method dalam format "Controller@method".
     * @param bool $middleware Apakah middleware diaktifkan untuk rute ini.
     */
    private function addRoute($method, $path, $action, $middleware)
    {
        // Ubah parameter dinamis {parameter} menjadi regex
        $regexPath = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '([^/]+)', $path);
        $this->routes[] = [
            'method' => $method,
            'path' => $regexPath,
            'action' => $action,
            'middleware' => $middleware,
            'original_path' => $path, // Untuk referensi
        ];

    }

    /**
     * Method untuk memproses rute berdasarkan URL dan HTTP method.
     *
     * @param string $url URL yang diminta.
     * @param string $method HTTP method (GET/POST).
     */
    public function resolve($url, $method)
    {
        // Menghapus query string dari URL
        $url = strtok($url, '?');

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match('#^' . $route['path'] . '$#', $url, $matches)) {
                array_shift($matches); // Hapus elemen pertama (URL lengkap)

                // Jika middleware diaktifkan
                if ($route['middleware']) {
                    // Middleware bisa diimplementasikan di sini
                    require_once BASE_PATH . '/middlewares/SessionMiddleware.php';
                    SessionMiddleware::validateSession();
                }

                // Panggil controller dan method
                $this->callAction($route['action'], $matches);
                return;
            }
        }

        echo "404 Not Found";
    }

    /**
     * Method untuk memanggil controller dan method berdasarkan action.
     *
     * @param string $action Controller dan method dalam format "Controller@method".
     */
    private function callAction($action, $params = [])
    {
        list($controller, $method) = explode('@', $action);

        // Include controller file
        require_once "controllers/$controller.php";

        // Inisialisasi controller
        $controllerInstance = new $controller;

        // Panggil method
        call_user_func_array([$controllerInstance, $method], $params); // Kirim parameter ke method
    }
}
