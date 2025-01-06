<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\CategoryController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/categories/index' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    (new CategoryController())->index();
} elseif ($uri === '/categories/create' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    (new CategoryController())->create();
} elseif ($uri === '/categories/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new CategoryController())->create();
} elseif (preg_match('/\/categories\/edit\/(\d+)/', $uri, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    (new CategoryController())->edit($matches[1]);
} elseif (preg_match('/\/categories\/edit\/(\d+)/', $uri, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new CategoryController())->edit($matches[1]);
} elseif (preg_match('/\/categories\/delete\/(\d+)/', $uri, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    (new CategoryController())->delete($matches[1]);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
}
