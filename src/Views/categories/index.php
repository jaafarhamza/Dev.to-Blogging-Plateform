<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
    <h1>Categories</h1>
    <a href="../categories/create.php">Create Category</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php
        require_once __DIR__ . '/../../Controllers/CategoryController.php'; 
        use App\Controllers\CategoryController;

        $controller = new CategoryController();
        if (isset($_GET['delete_id'])) {
            $id = intval($_GET['delete_id']); 
            if ($controller->deleteCategory($id)) {
                header('Location: /categories?message=Category deleted successfully.');
                exit();
            } else {
                header('Location: /categories?error=deletion_failed');
                exit();
            }
        }
        $categories = $controller->index();
        if (isset($categories) && is_array($categories)): 
            foreach ($categories as $category): 
        ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= $category['name'] ?></td>
                <td>
                <a href="../categories/edit.php?id=<?= htmlspecialchars($category['id']) ?>">Edit</a>
                    <a href="?delete_id=<?= htmlspecialchars($category['id']) ?>" 
                       onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No categories found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
