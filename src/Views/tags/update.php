<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\TagController;
$controller = new TagController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    if ($controller->updateTag($id, $name)) {
        header('Location: /tags?message=Tag updated successfully.');
        exit();
    } else {
        header('Location: ../tags/index.php');
        exit();
    }
}
