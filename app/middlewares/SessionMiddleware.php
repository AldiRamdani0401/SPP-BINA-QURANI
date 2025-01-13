<?php
class SessionMiddleware {
  public static function validateSession() {
      // Database
      $servername = "localhost";
      $port = 9090;
      $username = "root";
      $password = "root";
      $dbname = "db_spp_bina_qurani";

      $conn = new mysqli($servername, $username, $password, $dbname, $port);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Check Session
    if (isset($_SESSION['token']) && $_SESSION['token']) {
      $session = $_SESSION['token'];
      // $session = "298d014649b664bd998ccd10655ac16413697a6b3784e59144f287b34990e9b";
      // Data User
      $stmt = $conn->prepare("SELECT * FROM sessions WHERE token = ?");
      $stmt->bind_param("s", $session);
      $stmt->execute();
      $result = $stmt->get_result();
      // Check Session Result
      if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
      } else {
          header("Location:/");
          die();
      }
    } else {
      header("Location:/");
      die();
    }
  }
}