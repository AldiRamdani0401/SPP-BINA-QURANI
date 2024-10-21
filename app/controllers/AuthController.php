<?php
require __DIR__ . "/../core/Controller.php";
require __DIR__ . "/../core/Session.php";

// Models
require __DIR__ . "/../models/UserModel.php";

class AuthController extends Controller
{
  public function login(): void
  {
    $this->render(
      role: '',
      view: '/login',
      data: [
        "title" => "Login",
      ]);
  }

  public function loginAction(): void
  {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Retrieve and sanitize input data
      $email = filter_input(type: INPUT_POST, var_name: 'email', filter: FILTER_SANITIZE_EMAIL);
      $password = filter_input(type: INPUT_POST, var_name: 'password', filter: FILTER_SANITIZE_STRING);

      // Validate input (basic example)
      if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        return;
      }

      // Fetch user by email
      $userModel = new UserModel();
      $user = $userModel->getUserByParams(params: ['email' => $email]); // Use associative array for params

      if ($user && $password == $user[0]['password']) { // Adjust if using associative array
        // Successful login
        $session = new Session(key: 'aldiganteng');

        // // Generate a token
        $userData = [
          'key1' => $user[0]['id'],
          'key2' => $user[0]['email'],
          'key3' => $user[0]['fullname'],
          'key4' => $user[0]['role'],
        ];

        // Set session variable
        $token = $session->generateToken(data: $userData);
        $session->set(key: 'access-token', value: $token);

        header(header: "Location: /" . $user[0]['role']); // Redirect to a protected area
        exit();
      } else {
        echo "Invalid email or password.";
      }
    } else {
      // If not a POST request, redirect to login
      header(header: "Location: /login");
      exit();
    }
  }
}


// $session = new Session('your-secret-key');

// // Set session variable
// $session->set('user_id', 123);

// // Generate a token
// $userData = ['user_id' => 123, 'username' => 'exampleUser'];
// $token = $session->generateToken($userData);
// echo "Generated Token: " . $token . PHP_EOL;

// // Decode the token
// $decodedData = $session->decodeToken($token);
// print_r($decodedData);