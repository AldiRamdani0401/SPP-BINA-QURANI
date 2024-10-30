<?php
require __DIR__ . "/../core/Controller.php";

class DefaultController extends Controller {
  public function index(): void {
      $this->render(
        role: '',
        view: 'pages/home',
        data: ["title" => "Home"],
      );
  }
}