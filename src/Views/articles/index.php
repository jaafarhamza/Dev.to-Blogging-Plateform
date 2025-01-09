<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Controllers\ArticleController;
use App\Models\Article;
$controller = new ArticleController();
$articles = $controller->index();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Articles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Articles</h1>
            <a href="../articles/create.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Nouvel Article
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($articles as $article): ?>
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if ($article['featured_image']): ?>
                        <img
                            src="<?=htmlspecialchars($article['featured_image'])?>"
                            alt="<?=htmlspecialchars($article['title'])?>"
                            class="w-full h-48 object-cover"
                        >
                    <?php endif; ?>

                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="<?=getStatusClass($article['status'])?>">
                                <?=ucfirst($article['status'])?>
                            </span>
                            <span class="text-sm text-gray-500">
                                <?=formatDate($article['created_at'])?>
                            </span>
                        </div>

                        <h2 class="text-xl font-semibold mb-2">
                            <?=htmlspecialchars($article['title'])?>
                        </h2>

                        <p class="text-gray-600 mb-4">
                            <?=htmlspecialchars(substr($article['excerpt'] ?? $article['content'], 0, 150))?>...
                        </p>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="../articles/edit.php/<?=$article['id']?>"
                                   class="text-blue-500 hover:text-blue-600">
                                    Modifier
                                </a>
                                <a href="/articles/view/<?=$article['id']?>"
                                   class="text-green-500 hover:text-green-600">
                                    Voir
                                </a>
                            </div>
                            <span class="text-sm text-gray-500">
                                Vues: <?=$article['views']?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <?php

function getStatusClass($status)
{
    return match ($status) {
        'published' => 'px-2 py-1 rounded text-sm bg-green-100 text-green-800',
        'draft' => 'px-2 py-1 rounded text-sm bg-gray-100 text-gray-800',
        'scheduled' => 'px-2 py-1 rounded text-sm bg-yellow-100 text-yellow-800',
        default => 'px-2 py-1 rounded text-sm bg-gray-100 text-gray-800'
    };
}

function formatDate($date)
{
    return date('d/m/Y', strtotime($date));
}
?>
</body>
</html>
