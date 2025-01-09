<?php
namespace App\Config;
require_once __DIR__ . '/../../vendor/autoload.php';

use PDO;

class MethodORM {
    protected $table;
    protected $conn;

    public function __construct($table) {
        $this->table = $table;
        $this->conn = Database::connection();
        if (!$this->conn) {
            throw new \Exception("Failed to connect to the database.");
        }
    }

    public function create($data) {
        if (!is_array($data) || empty($data)) {
            error_log("Invalid data provided to create method. Expected an associative array.");
            return false;
        }
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO " . $this->table . " ($columns) VALUES ($values)";
        
        $stmt = $this->conn->prepare($query);
    
        foreach ($data as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }
        if ($stmt->execute()) {
            echo 'Create successful';
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Error executing query: " . $errorInfo[2]);
            return false;
        }
    }
    

    public function read($conditions = []) {
        $query = "SELECT * FROM " . $this->table;

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", array_map(function($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }
        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo 'Read successful';
        return $result;
    }
    public function findAll($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be an array');
        }
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "$key = :$key";
        }
        $setString = implode(', ', $setParts);

        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET $setString WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Error executing delete query: " . $errorInfo[2]);
            return false;
        }
    }
}
