<?php

namespace App;

class User { 
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password)
{
    $stmt = $this->conn->prepare("SELECT id, password, role FROM users WHERE email = ?");

    if ($stmt === false) {
        return null; 
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close(); 

    if ($user && password_verify($password, $user['password'])) {
        return [
                "id" => $user["id"],
                "role" => $user["role"]
            ];
    }
    return null;
}
}
?>
