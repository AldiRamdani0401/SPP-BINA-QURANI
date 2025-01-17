<?php

class Database
{
  private $host;
  private $dbName;
  private $username;
  private $password;
  private $pdo;

  // Constructor untuk inisialisasi
  public function __construct($host, $dbName, $username, $password)
  {
    $this->host = $host;
    $this->dbName = $dbName;
    $this->username = $username;
    $this->password = $password;
    $this->connect();
  }

  // Koneksi ke database menggunakan PDO
  private function connect()
  {
    try {
      $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
      $this->pdo = new PDO($dsn, $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Koneksi database gagal: " . $e->getMessage());
    }
  }

  // Eksekusi query SELECT (dengan opsi parameter)
  public function query($sql, $params = [])
  {
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Query gagal: " . $e->getMessage());
    }
  }

  // Eksekusi query INSERT, UPDATE, DELETE
  public function execute($sql, $params = [])
  {
    try {
      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute($params);
    } catch (PDOException $e) {
      die("Eksekusi gagal: " . $e->getMessage());
    }
  }

  // Mendapatkan ID terakhir setelah INSERT
  public function lastInsertId()
  {
    return $this->pdo->lastInsertId();
  }
}
