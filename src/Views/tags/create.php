<?php
require_once __DIR__ . '/../../Controllers/TagController.php'; 
use App\Controllers\TagController;

$controller = new TagController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $controller->create();
        header('Location: /tags'); 
        exit();
    } catch (Exception $e) {
        error_log('Error creating Tag: ' . $e->getMessage());
        $errorMessage = "There was an error creating the Tag. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Tag</title>
</head>
<body>
    <h1>Create Tag</h1>
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

