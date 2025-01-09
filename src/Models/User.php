
<?php
namespace App\Models;

use App\Config\Database;
use \PDO;

class User {
    protected $table = 'users';
    protected $conn;

    public function __construct() {
        $this->conn = Database::connection();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (username, email, password_hash, bio, profile_picture_url) 
                VALUES (:username, :email, :password_hash, :bio, :profile_picture_url)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'bio' => $data['bio'],
            'profile_picture_url' => $data['profile_picture_url'] ?? null
        ]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
