<?php
require_once __DIR__ . '/../../Controllers/CategoryController.php'; 
use App\Controllers\CategoryController;

$controller = new CategoryController();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $category = $controller->getCategoryById($id); 

    if (!$category) {
        header('Location: /categories?error=category_not_found');
        exit();
    }
} else {
    header('Location: /categories?error=no_id_provided');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>
    <form action="../categories/update.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($category['name']) ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="/categories">Cancel</a>
</body>
</html>
