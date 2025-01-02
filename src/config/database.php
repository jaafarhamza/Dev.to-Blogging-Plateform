<?php
// filepath: /C:/laragon/www/Dev.to-Blogging-Plateform/mon-projet/src/config/database.php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Database configuration settings from .env
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'done';
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>