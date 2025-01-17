<?php

class Route
{
  private $routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
  ];

  public function add($method, $route, $callback)
  {
    $method = strtoupper($method);
    if (in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
      $this->routes[$method][$route] = $callback;
    } else {
      throw new Exception("Unsupported HTTP method: $method");
    }
  }

  public function dispatch($requestedRoute, $method)
  {
    $method = strtoupper($method);
    if (array_key_exists($method, $this->routes) && array_key_exists($requestedRoute, $this->routes[$method])) {
      call_user_func($this->routes[$method][$requestedRoute]);
    } else {
      echo "404 Not Found";
    }
  }

  public function run()
  {

    // Implement the logic for running the router

  }
}