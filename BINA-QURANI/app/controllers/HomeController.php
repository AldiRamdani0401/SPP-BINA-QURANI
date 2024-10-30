<?php
require __DIR__ . "/../core/Controller.php";

class HomeController extends Controller {
  public function index(): void {
      $data = ['message' => 'Welcome to the Home Page!'];
      $this->render(
        role: '',
        view: 'home',
        data: ["title" => "Home"],
      );
  }
}