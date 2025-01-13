<?php

class AuthController
{
  public function login()
  {
    if (isset($_POST['email']) && isset($_POST['password'])) {
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

      $email = $_POST['email'];
      $password = $_POST['password'];

      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
      $stmt->bind_param("ss", $email, $password);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        require_once BASE_PATH . "/security/Session.php";
        // GET & SET Session
        $userRole = Sessions::generate([$user['id'], $user['role']]);
        if ($userRole === 'admin') {
            // Set storage_key di session
            $_SESSION['storage_key'] = '112233';

            // Set storage_key di cookie
            setcookie("storage_key", "112233", time() + (86400 * 30), "/");

            // Redirect ke /admin
            header("Location: /admin");
            exit;

        } else if ($user['role'] === 'user') {
          // header("Location: /admin");
        } else {
          return false;
        }
      } else {
        return header("Location: /?error=1");
      }

      $stmt->close();
      $conn->close();

    } else {
      echo "forbidden";
      return false;
    }
    // $path = BASE_PATH . "/views/general/index.php";
    // require_once $path;
  }
}
