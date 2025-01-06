<!DOCTYPE html>
<html>
<head>
    <title>tags</title>
</head>
<body>
    <h1>tags</h1>
    <a href="../tags/create.php">Create Tag</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php
        require_once __DIR__ . '/../../Controllers/TagController.php'; 
        use App\Controllers\TagController;

        $controller = new TagController();
        if (isset($_GET['delete_id'])) {
            $id = intval($_GET['delete_id']); 
            if ($controller->deleteTag($id)) {
                header('Location: /tags?message=Tag deleted successfully.');
                exit();
            } else {
                header('Location: /tags?error=deletion_failed');
                exit();
            }
        }
        $tags = $controller->index();
        if (isset($tags) && is_array($tags)): 
            foreach ($tags as $Tag): 
        ?>
            <tr>
                <td><?= $Tag['id'] ?></td>
                <td><?= $Tag['name'] ?></td>
                <td>
                <a href="../tags/edit.php?id=<?= htmlspecialchars($Tag['id']) ?>">Edit</a>
                    <a href="?delete_id=<?= htmlspecialchars($Tag['id']) ?>" 
                       onclick="return confirm('Are you sure you want to delete this Tag?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No tags found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
