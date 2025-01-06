<?php
namespace App\Controllers;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\tag;

class TagController {
    private $tagModel;

    public function __construct() {
        $this->tagModel = new tag();
    }

    public function index() {
        $categories = $this->tagModel->read();
        return $categories; 
    }
    

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    
            if (empty($name)) {
                error_log("tag name cannot be empty.");
                header('Location: /categories/create?error=empty');
                exit();
            }
            $data = [
                'name' => $name,
            ];
            if ($this->tagModel->create($data)) {
                header('Location: /categories');
                exit();
            } else {
                error_log("Failed to create tag: " . $name);
                header('Location: /categories/create?error=creation_failed');
                exit();
            }
        }
    }   
    
    public function updatetag($id, $name) {
        $tagModel = new tag();
        $data = ['name' => $name];
        $tagModel->update($id, $data);
    }

    public function gettagById($id) {
        return $this->tagModel->find($id);
    }

    public function edit($id) {
        $tag = $this->tagModel->read(['id' => $id])[0];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tagModel->update($_POST, ['id' => $id]);
            header('Location: /categories');
            exit;
        }
        include __DIR__ . '/../views/categories/edit.php';
    }
    public function deletetag($id) {
        return $this->tagModel->delete($id);
    }
    public function delete($id) {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            header('Location: /categories?error=invalid_id');
            exit();
        }
        if ($this->tagModel->delete($id)) {
            header('Location: /categories?message=tag deleted successfully.');
            exit();
        } else {
            header('Location: /categories?error=deletion_failed');
            exit();
        }
    }
    
    
}
