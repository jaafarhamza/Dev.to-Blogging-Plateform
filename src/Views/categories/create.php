<?php
require_once __DIR__ . '/../../Controllers/CategoryController.php'; 
use App\Controllers\CategoryController;

$controller = new CategoryController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $controller->create();
        header('Location: /categories'); 
        exit();
    } catch (Exception $e) {
        error_log('Error creating category: ' . $e->getMessage());
        $errorMessage = "There was an error creating the category. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Category</title>
</head>
<body>
    <h1>Create Category</h1>
    <?php if (isset($errorMessage)): ?>
        <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Create</button>
    </form>
</body>
</html>
