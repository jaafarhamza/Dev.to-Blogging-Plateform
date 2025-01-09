<?php
namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class ArticleController
{
    private $articleModel;
    private $categoryModel;
    private $tagModel;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->categoryModel = new Category();
        $this->tagModel = new Tag();
    }

    public function index()
    {
        return $this->articleModel->getAllArticles();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // $categories = $this->categoryModel->getAllCategories();
            // $tags = $this->tagModel->getAllTags();
            include __DIR__ . '/../views/articles/create.php';
            return;
        }

        try {
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'excerpt' => $_POST['excerpt'],
                'meta_description' => $_POST['meta_description'],
                'category_id' => $_POST['category_id'],
                'author_id' => $_SESSION['user_id'],
                'status' => $_POST['status'],
                'scheduled_date' => !empty($_POST['scheduled_date']) ? $_POST['scheduled_date'] : null,
            ];

            if (isset($_FILES['featured_image'])) {
                $data['featured_image'] = $_FILES['featured_image'];
            }

            $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

            $this->articleModel->createArticle($data, $tags);

            header('Location: /articles');
            exit();

        } catch (\Exception $e) {
            error_log($e->getMessage());
            header('Location: /articles/create?error=' . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit($id)
    {
        $article = $this->articleModel->getArticleById($id);
        require_once '../src/Views/articles/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category_id' => $_POST['category_id'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->articleModel->updateArticle($id, $data)) {
                header('Location: /articles');
                exit();
            }
        }
    }

    public function delete($id)
    {
        try {
            $this->articleModel->delete($id);
            header('Location: /articles?message=Article supprimé avec succès');
            exit();
        } catch (\Exception $e) {
            header('Location: /articles?error=' . urlencode($e->getMessage()));
            exit();
        }
    }
}
