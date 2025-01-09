<?php
namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config\Database;
use App\Config\MethodORM;
use PDO;

class Article extends MethodORM
{
    protected $table = 'articles';
    protected $conn;

    public function __construct()
    {
        parent::__construct('articles');
        $this->conn = Database::connection();
    }

    public function getAllArticles()
    {

        $sql = "SELECT a.*
                FROM {$this->table} a
                ORDER BY a.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id)
    {
        $sql = "SELECT a.*, c.name as category_name, u.name as author_name
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                WHERE a.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateArticle($id, $data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $data['id'] = $id;

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function createArticle($data, $tags = [])
    {
        try {
            $this->conn->beginTransaction();
            $data['slug'] = $this->generateSlug($data['title']);
            if (isset($data['featured_image']) && $data['featured_image']['error'] === 0) {
                $data['featured_image'] = $this->handleImageUpload($data['featured_image']);
            }
            $data['status'] = $data['status'] ?? 'draft';
            $data['views'] = 0;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $articleId = parent::create($data);
            if (!empty($tags)) {
                $this->attachTags($articleId, $tags);
            }
            return $articleId;

        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    private function generateSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $baseSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists($slug)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM articles WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetchColumn() > 0;
    }

    private function handleImageUpload($file)
    {
        $uploadDir = __DIR__ . '/../public/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'uploads/articles/' . $fileName;
        }

        throw new \Exception('Erreur lors du téléchargement de l\'image');
    }

    private function attachTags($articleId, $tags)
    {
        foreach ($tags as $tagId) {
            $stmt = $this->conn->prepare("INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$articleId, $tagId]);
        }
    }

    public function getArticleWithDetails($id)
    {
        $query = "SELECT a.*, c.name as category_name, u.username as author_name,
                  GROUP_CONCAT(t.name) as tags
                  FROM articles a
                  LEFT JOIN categories c ON a.category_id = c.id
                  LEFT JOIN users u ON a.author_id = u.id
                  LEFT JOIN article_tags at ON a.id = at.article_id
                  LEFT JOIN tags t ON at.tag_id = t.id
                  WHERE a.id = ?
                  GROUP BY a.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementViews($id)
    {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
