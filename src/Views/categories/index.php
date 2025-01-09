<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <title>Gestion des Catégories</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- En-tête -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                <a href="../Dashboard/Dashboard.php"
                           class="inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            Annuler
                        </a>
                    <h1 class="text-2xl font-bold text-gray-900">Gestion des Catégories</h1>
                    <a href="../categories/create.php"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nouvelle Catégorie
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Messages de notification -->
            <?php if (isset($_GET['message'])): ?>
                <div class="mb-4 rounded-lg bg-green-50 p-4 animate-fade-in">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                <?=htmlspecialchars($_GET['message'])?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tableau des catégories -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                                     require_once __DIR__ . '/../../../vendor/autoload.php';
                                     use App\Controllers\CategoryController;
                                     
                                     $controller = new CategoryController();
                                     if (isset($_GET['delete_id'])) {
                                         $id = intval($_GET['delete_id']);
                                         if ($controller->deleteCategory($id)) {
                                            header('Location: ../categories/index.php');
                                             exit();
                                         } else {
                                             header('Location: /categories?error=La suppression a échoué');
                                             exit();
                                         }
                                     }
                                     $categories = $controller->index();
                                     if (isset($categories) && is_array($categories)):
                                         foreach ($categories as $category):
                                         ?>
	                                <tr class="hover:bg-gray-50 transition-colors duration-200">
	                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
	                                        <?=$category['id']?>
	                                    </td>
	                                    <td class="px-6 py-4 whitespace-nowrap">
	                                        <div class="flex items-center">
	                                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center">
	                                                <span class="text-sm font-medium text-indigo-600">
	                                                    <?=strtoupper(substr($category['name'], 0, 1))?>
	                                                </span>
	                                            </div>
	                                            <div class="ml-4">
	                                                <div class="text-sm font-medium text-gray-900">
	                                                    <?=htmlspecialchars($category['name'])?>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </td>
	                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
	                                        <div class="flex justify-end space-x-2">
	                                            <a href="../categories/edit.php?id=<?=htmlspecialchars($category['id'])?>"
	                                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
	                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
	                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
	                                                </svg>
	                                                Modifier
	                                            </a>
	                                            <a href="?delete_id=<?=htmlspecialchars($category['id'])?>"
	                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"
	                                               class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
	                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
	                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
	                                                </svg>
	                                                Supprimer
	                                            </a>
	                                        </div>
	                                    </td>
	                                </tr>
	                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center py-6">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <p class="mt-2">Aucune catégorie trouvée.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</body>
</html>
