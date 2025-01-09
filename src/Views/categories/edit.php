<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
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
<html lang="fr" class="h-full bg-gray-50">
<head>
    <title>Modifier la Catégorie</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="h-full">
    <div class="min-h-full">
        <div class="py-10">
            <header>
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        Modifier la Catégorie
                    </h1>
                </div>
            </header>

            <main>
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white mt-8 px-4 py-5 shadow rounded-lg sm:px-6">
                        <form action="../categories/update.php" method="post" class="space-y-6">
                            <input type="hidden" name="id" value="<?=htmlspecialchars($category['id'])?>">

                            <!-- Champ Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nom de la catégorie
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="<?=htmlspecialchars($category['name'])?>"
                                           required
                                           class="block w-full pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                           placeholder="Entrez le nom de la catégorie">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex justify-end space-x-3 pt-5">
                                <a href="../Dashboard/Dashboard.php"
                                   class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Carte d'information -->
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    Les modifications seront immédiatement appliquées à tous les articles associés à cette catégorie.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animation de focus pour le champ de saisie */
        input:focus {
            transition: all 0.2s ease-in-out;
        }

        /* Animation pour les boutons */
        button, a {
            transition: all 0.2s ease-in-out;
        }
    </style>
</body>
</html>
