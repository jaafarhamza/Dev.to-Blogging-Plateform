<?php
namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Category;

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $categories = $this->categoryModel->read();
        return $categories;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';

            if (empty($name)) {
                error_log("Category name cannot be empty.");
                header('Location: /categories/create?error=empty');
                exit();
            }
            $data = [
                'name' => $name,
            ];
            if ($this->categoryModel->create($data)) {
                header('Location: ../Dashboard/Dashboard.php');
                exit();
            } else {
                error_log("Failed to create category: " . $name);
                header('Location: /categories/create?error=creation_failed');
                exit();
            }
        }
    }

    public function updateCategory($id, $name)
    {
        $categoryModel = new Category();
        $data = ['name' => $name];
        $categoryModel->update($id, $data);
        header('Location: ../Dashboard/Dashboard.php');
    }

    public function getCategoryById($id)
    {
        return $this->categoryModel->findAll($id);
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->update($_POST, ['id' => $id]);
            header('Location: ../Dashboard/Dashboard.php');
            exit;
        }
    }
    public function deleteCategory($id)
    {
        return $this->categoryModel->delete($id);
    }
    public function delete($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            header('Location: /categories?error=invalid_id');
            exit();
        }
        if ($this->categoryModel->delete($id)) {
            header('Location: ../categories/index.php');
            exit();
        } else {
            header('Location: /categories?error=deletion_failed');
            exit();
        }
    }

}
