<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\CategoryController;
$controller = new CategoryController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    if ($controller->updateCategory($id, $name)) {
        header('Location: /categories?message=Category updated successfully.');
        exit();
    } else {
        header('Location: ../categories/index.php');
        exit();
    }
}
