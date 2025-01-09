    <?php
    require_once __DIR__ . '/../../../vendor/autoload.php';

    ?>

    <div class="container mt-4">
        <h1>Modifier l'article</h1>
        
        <form action="/articles/update/<?= $article['id'] ?>" method="POST">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" 
                    class="form-control" 
                    id="title" 
                    name="title" 
                    value="<?= htmlspecialchars($article['title']) ?>" 
                    required>
            </div>

            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea class="form-control" 
                        id="content" 
                        name="content" 
                        rows="10" 
                        required><?= htmlspecialchars($article['content']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" 
                                <?= $category['id'] == $article['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="/articles" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

