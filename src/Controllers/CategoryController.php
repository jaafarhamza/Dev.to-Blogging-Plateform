<?php
namespace App\Controllers;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Category;

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->read();
        return $categories; 
    }
    

    public function create() {
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
                header('Location: /categories');
                exit();
            } else {
                error_log("Failed to create category: " . $name);
                header('Location: /categories/create?error=creation_failed');
                exit();
            }
        }
    }   
    
    public function updateCategory($id, $name) {
        $categoryModel = new Category();
        $data = ['name' => $name];
        $categoryModel->update($id, $data);
    }

    public function getCategoryById($id) {
        return $this->categoryModel->find($id);
    }

    public function edit($id) {
        $category = $this->categoryModel->read(['id' => $id])[0];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->update($_POST, ['id' => $id]);
            header('Location: /categories');
            exit;
        }
        include __DIR__ . '/../views/categories/edit.php';
    }
    public function deleteCategory($id) {
        return $this->categoryModel->delete($id);
    }
    public function delete($id) {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            header('Location: /categories?error=invalid_id');
            exit();
        }
        if ($this->categoryModel->delete($id)) {
            header('Location: /categories?message=Category deleted successfully.');
            exit();
        } else {
            header('Location: /categories?error=deletion_failed');
            exit();
        }
    }
    
    
}
