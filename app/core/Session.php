<?php
class Session {
  private $encryptionKey;

  public function __construct($key) {
      $this->encryptionKey = $key;

      // Regenerate session ID to prevent fixation attacks
      if (empty($_SESSION['initialized'])) {
          session_regenerate_id(delete_old_session: true); // true to delete the old session
          $_SESSION['initialized'] = true; // Mark session as initialized
      }
  }

  // Set a session variable
  public function set($key, $value): void {
      $_SESSION[$key] = $value;
  }

  // Get a session variable
  public function get($key): mixed {
      return $_SESSION[$key] ?? null; // Return null if not set
  }

  // Check if a session variable is set
  public function has($key): bool {
      return isset($_SESSION[$key]);
  }

  // Remove a session variable
  public function remove($key): void {
      unset($_SESSION[$key]);
  }

  // Destroy the session
  public function destroy(): void {
      session_destroy();
      $_SESSION = []; // Clear the session array
  }

  // Regenerate session ID (optional method)
  // public function regenerate(): void {
  //     session_regenerate_id(delete_old_session: true); // Regenerate session ID
  // }

  // Generate a secure token
  public function generateToken(array $data): string {
      $dataJson = json_encode(value: $data);
      $iv = openssl_random_pseudo_bytes(length: openssl_cipher_iv_length(cipher_algo: 'aes-256-cbc'));
      $encryptedData = openssl_encrypt(data: $dataJson, cipher_algo: 'aes-256-cbc', passphrase: $this->encryptionKey, options: 0, iv: $iv);
      return base64_encode(string: $encryptedData . '::' . $iv);
  }

  // Decode a secure token
  public function decodeToken(string $token): array|null {
      list($encryptedData, $iv) = explode(separator: '::', string: base64_decode(string: $token), limit: 2);
      $decryptedData = openssl_decrypt(data: $encryptedData, cipher_algo: 'aes-256-cbc', passphrase: $this->encryptionKey, options: 0, iv: $iv);
      return json_decode(json: $decryptedData, associative: true);
  }
}
