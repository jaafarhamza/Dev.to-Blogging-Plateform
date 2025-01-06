<?php
namespace App\Views\Dashboard;
require_once __DIR__ . '/../../../vendor/autoload.php';

use PDO;
// Database::connection();

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
                <a href="#" class="block py-2.5 px-4 hover:bg-blue-700">Home</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-blue-700">Categories</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-blue-700">Tags</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-blue-700">Users</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-blue-700">Articles</a>
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
                        <h2 class="text-xl font-bold mb-2">Categories</h2>
                        <p class="text-gray-700">Manage categories, view statistics, and more.</p>
                        <button class="mt-4 bg-blue-500 text-white hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 rounded">Create Category</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold mb-2">Tags</h2>
                        <p class="text-gray-700">Manage tags, view statistics, and more.</p>
                        <button class="mt-10 bg-blue-500 text-white  hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 px-4 py-2 rounded">Create Tag</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold mb-2">Users</h2>
                        <p class="text-gray-700">Manage user profiles, permissions, and more.</p>
                        <button class="mt-4 bg-blue-500 text-white  hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 px-4 py-2 rounded">Manage Users</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold mb-2">Articles</h2>
                        <p class="text-gray-700">Review, approve, and manage articles.</p>
                        <button class="mt-10 bg-blue-500 text-white  hover:text-blue-500 hover:bg-white font-bold px-4 py-2 border-2 border-blue-500 duration-500 px-4 py-2 rounded">Manage Articles</button>
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
