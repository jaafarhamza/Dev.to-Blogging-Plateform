<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Controllers\TagController;
use App\Controllers\CategoryController;
$controller = new CategoryController();
$categories = $controller->index();
$controller = new TagController();
$tags = $controller->index();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Créer un Article</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/forms@0.5.3/dist/forms.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- En-tête -->
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-indigo-600">
                    <h1 class="text-2xl font-bold text-white">Créer un Nouvel Article</h1>
                </div>

                <!-- Message d'erreur -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700"><?= htmlspecialchars($_GET['error']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form method="POST" action="./create.php" enctype="multipart/form-data" class="p-6 space-y-6">
                    <!-- Titre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contenu</label>
                        <textarea name="content" required rows="6"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Extrait -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Extrait</label>
                        <textarea name="excerpt" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                        <input type="text" name="meta_description" maxlength="160"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Maximum 160 caractères</p>
                    </div>

                    <!-- Catégories et Tags -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Catégories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tags</label>
                            <select name="tags[]" multiple
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <?php foreach ($tags as $tag): ?>
                                    <option value="<?= $tag['id'] ?>">
                                        <?= htmlspecialchars($tag['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image à la une</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <!-- Preview Image Container -->
                                    <div id="imagePreview" class="hidden mb-4">
                                        <img src="" alt="Aperçu" class="mx-auto h-48 w-auto">
                                        <button type="button" id="removeImage" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                            Supprimer l'image
                                        </button>
                                    </div>

                                    <!-- Upload Icon (visible when no image) -->
                                    <div id="uploadIcon" class="flex flex-col items-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Télécharger un fichier</span>
                                                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Status caché -->
                    <!-- <input  type="" name="status" value="draft"> -->

                    <!-- Bouton de soumission -->
                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Créer l'article
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script pour Tom Select -->
    <script>
        new TomSelect('select[name="tags[]"]', {
            plugins: ['remove_button'],
            placeholder: 'Sélectionnez des tags...',
            maxItems: null,
            hideSelected: true,
            closeAfterSelect: true
        });
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('featured_image');
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    const uploadIcon = document.getElementById('uploadIcon');
    const removeButton = document.getElementById('removeImage');

    // Fonction pour afficher l'aperçu
    input.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
                uploadIcon.classList.add('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    });

    // Fonction pour supprimer l'image
    removeButton.addEventListener('click', function() {
        input.value = ''; // Réinitialise l'input file
        preview.classList.add('hidden');
        uploadIcon.classList.remove('hidden');
        previewImg.src = '';
    });
});
    </script>
</body>
</html>
