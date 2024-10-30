<?php

class UserModel extends Model {
    // Mengambil pengguna berdasarkan ID
    public function getUser($id): array|bool|null {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare(query: $sql);
        $stmt->bind_param(types: "i", var: $id); // "i" berarti integer
        $stmt->execute();
        $result = $stmt->get_result(); // Mendapatkan hasil
        return $result->fetch_assoc(); // Mengambil satu baris hasil sebagai array associative
    }

    public function getUserByParams(array $params): array|bool|null {
        // Base SQL query
        $sql = "SELECT * FROM users";

        // Initialize an array for conditions, types, and values
        $conditions = [];
        $types = '';
        $values = [];

        // Loop through the parameters to build conditions dynamically
        foreach ($params as $key => $value) {
            // Use prepared statements to prevent SQL injection
            $conditions[] = "$key = ?"; // Assuming $key is a valid column name
            $types .= is_string(value: $value) ? 's' : 'i'; // Determine the type
            $values[] = $value;
        }

        // Build the WHERE clause if there are conditions
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(separator: ' AND ', array: $conditions);
        }

        // Prepare the SQL statement
        $stmt = $this->db->prepare(query: $sql);

        // Bind parameters dynamically if conditions are present
        if ($conditions) {
            // Create a reference array for bind_param
            $bindParams = array_merge([$types], $values);
            $stmt->bind_param(...$bindParams); // Spread the parameters
        }

        // Execute the statement and get results
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(mode: MYSQLI_ASSOC); // Return results as associative array
    }


    // Mengambil semua pengguna
    public function getAllUsers(): array {
        $sql = "SELECT * FROM users";
        $result = $this->db->query(query: $sql);
        return $result->fetch_all(mode: MYSQLI_ASSOC); // Mengambil semua baris hasil sebagai array associative
    }
}

