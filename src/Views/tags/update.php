<?php
require_once __DIR__ . '/../../Controllers/TagController.php'; 
use App\Controllers\TagController;
$controller = new TagController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); 
    $name = trim($_POST['name']); 
    if ($controller->updateTag($id, $name)) {
        header('Location: /tags?message=Tag updated successfully.');
        exit();
    } else {
        header('Location: /tags?error=update_failed');
        exit();
    }
}
