<?php

class Sessions {
  public static function start() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  public static function generate($userData) {
    self::start();
    $token = bin2hex(random_bytes(32));
    return self::set('token', $token, $userData);
  }

  public static function set($key, $value, $datas) {
    $servername = "localhost";
    $port = 9090;
    $username = "root";
    $password = "root";
    $dbname = "db_spp_bina_qurani";

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM sessions WHERE user_id = ? AND token = ?");
    $stmt->bind_param("is", $datas[0], $value);

    $stmt->execute();
    $sessionResult = $stmt->get_result();

    if ($sessionResult->num_rows === 0) {
      $stmt = $conn->prepare("INSERT INTO sessions (user_id, token, access) VALUES (?, ?, ?)");
      $stmt->bind_param("iss", $datas[0], $value, $datas[1]);
      $stmt->execute();
      $_SESSION[$key] = $value;
      return $datas[1];
    }
  }

  public static function get($key) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
  }

  public static function delete($key) {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }
  }

  public static function destroy() {
    if (session_status() != PHP_SESSION_NONE) {
      session_destroy();
    }
  }
}