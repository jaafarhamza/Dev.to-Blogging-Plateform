<?php
require_once __DIR__ . '/../../Controllers/TagController.php'; 
use App\Controllers\TagController;

$controller = new TagController();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $Tag = $controller->getTagById($id); 

    if (!$Tag) {
        header('Location: /tags?error=Tag_not_found');
        exit();
    }
} else {
    header('Location: /tags?error=no_id_provided');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tag</title>
</head>
<body>
    <h1>Edit Tag</h1>
    <form action="../tags/update.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($Tag['id']) ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($Tag['name']) ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="/tags">Cancel</a>
</body>
</html>

