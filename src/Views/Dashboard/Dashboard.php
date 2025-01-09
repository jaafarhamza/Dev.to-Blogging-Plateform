<?php
namespace App\Views\Dashboard;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Config\Database;
use PDO;

$pdo = Database::connection();

$stmt = $pdo->query("SELECT COUNT(*) as category_count FROM categories");
$categoryCount = $stmt->fetch(PDO::FETCH_ASSOC)['category_count'];

$stmt = $pdo->query("SELECT COUNT(*) as tag_count FROM tags");
$tagCount = $stmt->fetch(PDO::FETCH_ASSOC)['tag_count'];

$stmt = $pdo->query("SELECT COUNT(*) as user_count FROM users");
$userCount = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];

$stmt = $pdo->query("SELECT COUNT(*) as article_count FROM articles");
$articleCount = $stmt->fetch(PDO::FETCH_ASSOC)['article_count'];

// Database::connection();

// requireLogin();
// requireRole('admin');

// echo "Bienvenue dans le tableau de bord admin.";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-blue-600 text-white flex flex-col">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            </div>
            <nav class="flex-grow">
                <a href="../Home/home.php" class="block py-2.5 px-4 hover:bg-blue-700">Home</a>
                <a href="../categories/index.php" class="block py-2.5 px-4 hover:bg-blue-700">Categories</a>
                <a href="../tags/index.php" class="block py-2.5 px-4 hover:bg-blue-700">Tags</a>
            </nav>
            <div class="p-4">
                <a href="#" class="block py-2.5 px-4 bg-red-700 hover:bg-red-900 rounded">Logout</a>
            </div>
        </aside>
        <div class="flex-grow flex flex-col">
            <header class="bg-white shadow-md p-4">
                <div class="container mx-auto flex justify-between items-center">
                    <h2 class="text-xl font-bold">Welcome, Admin</h2>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Profile Picture" class="rounded-full mr-2">
                        <span>Admin Name</span>
                    </div>
                </div>
            </header>
            <main class="flex-grow container mx-auto p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-md">
                  <div class="flex justify-between items-start mb-2">
                      <h2 class="text-xl font-bold">Catégories</h2>
                      <div class="flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <span class="text-blue-700 font-semibold"><?=htmlspecialchars($categoryCount)?></span>
                      </div>
                  </div>
                  <p class="text-gray-700">Gérez les catégories, consultez les statistiques et plus encore.</p>
                  <a href="../categories/create.php" class="mt-4 inline-block bg-blue-500 text-white hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 rounded">
                             Add Category
                  </a>
              </div>
              <div class="bg-white p-6 rounded-lg shadow-md">
                         <div class="flex justify-between items-start mb-2">
                             <h2 class="text-xl font-bold">Tags</h2>
                             <div class="flex items-center gap-2 bg-green-50 px-3 py-1 rounded-lg">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                                 </svg>
                                 <span class="text-green-700 font-semibold"><?=htmlspecialchars($tagCount)?></span>
                             </div>
                         </div>
                         <p class="text-gray-700">Gérez les tags, organisez votre contenu et améliorez la navigation.</p>
                         <a href="../tags/create.php" class="mt-4 inline-block bg-blue-500 text-white hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 rounded">
                             Add tags
                         </a>
                     </div>
                     <div class="bg-white p-6 rounded-lg shadow-md">
                              <div class="flex justify-between items-start mb-2">
                                  <h2 class="text-xl font-bold">Utilisateurs</h2>
                                  <div class="flex items-center gap-2 bg-purple-50 px-3 py-1 rounded-lg">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                      </svg>
                                      <span class="text-purple-700 font-semibold"><?=htmlspecialchars($userCount)?></span>
                                  </div>
                              </div>
                              <p class="text-gray-700">Gérez les utilisateurs, les rôles et les permissions.</p>
                              <button class="mt-4 bg-blue-500 text-white hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 rounded">
                                  Manage Users
                              </button>
                          </div>

                          <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex justify-between items-start mb-2">
                                <h2 class="text-xl font-bold">Articles</h2>
                                <div class="flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8" />
                                    </svg>
                                    <span class="text-blue-700 font-semibold"><?=htmlspecialchars($articleCount)?></span>
                                </div>
                            </div>
                            <p class="text-gray-700">Gérez vos articles, publiez du contenu et suivez les statistiques.</p>
                            <button class="mt-4 bg-blue-500 text-white hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 rounded">
                                Manage Articles
                            </button>
                        </div>

                </div>
                <div class="mt-8">
                    <h2 class="text-2xl font-bold mb-4">Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-2">Top Authors</h3>
                            <p class="text-gray-700">View the top 3 authors based on published or read articles.</p>
                            <canvas id="topAuthorsChart"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-2">Popular Articles</h3>
                            <p class="text-gray-700">View the most popular articles.</p>
                            <canvas id="popularArticlesChart"></canvas>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-2">Category Statistics</h3>
                            <canvas id="categoryStatsChart"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-2">Tag Statistics</h3>
                            <canvas id="tagStatsChart"></canvas>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="bg-gray-800 text-white p-4">
                <div class="container mx-auto text-center">
                    &copy; 2025 Dev.to Blogging Platform. All rights reserved.
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        const ctx1 = document.getElementById('topAuthorsChart').getContext('2d');
        const ctx2 = document.getElementById('popularArticlesChart').getContext('2d');
        const ctx3 = document.getElementById('categoryStatsChart').getContext('2d');
        const ctx4 = document.getElementById('tagStatsChart').getContext('2d');

        const data1 = {
            labels: ['Author 1', 'Author 2', 'Author 3'],
            datasets: [{
                label: 'Articles Published',
                data: [12, 19, 3],
                backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        };

        const data2 = {
            labels: ['Article 1', 'Article 2', 'Article 3'],
            datasets: [{
                label: 'Views',
                data: [150, 200, 100],
                backgroundColor: ['rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        };

        const data3 = {
            labels: ['Category 1', 'Category 2', 'Category 3'],
            datasets: [{
                label: 'Articles',
                data: [10, 20, 30],
                backgroundColor: ['rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(255, 159, 64, 1)'],
                borderWidth: 1
            }]
        };

        const data4 = {
            labels: ['Tag 1', 'Tag 2', 'Tag 3'],
            datasets: [{
                label: 'Articles',
                data: [5, 15, 25],
                backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };

        new Chart(ctx1, { type: 'bar', data: data1 });
        new Chart(ctx2, { type: 'bar', data: data2 });
        new Chart(ctx3, { type: 'pie', data: data3 });
        new Chart(ctx4, { type: 'pie', data: data4 });

    </script>
</body>
</html>
