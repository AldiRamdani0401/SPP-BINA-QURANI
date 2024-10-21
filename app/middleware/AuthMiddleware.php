<?php

class AuthMiddleware {
  public function handle($request): void {
    // Nanti akan dihubungkan dengan class Session
    // var_dump($_SESSION);
    // var_dump($request);
      // Logika otentikasi
      // if (!isset($_SESSION['key1']) && !isset($_SESSION['key2'])) {
      //     // Jika tidak ada user yang terautentikasi, redirect atau tampilkan pesan
      //     header('Location: /login');
      //     exit;
      // }
  }
}
