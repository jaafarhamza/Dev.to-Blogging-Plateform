
use dev_to_blogging_plateform;

-- Insert Categories
INSERT INTO categories (name) VALUES
('Front-end')


-- Insert Tags
INSERT INTO tags (name) VALUES
('JavaScript'),
('Docker'),
('Machine Learning'),
('Web Development')
-- ('DevOps'),
-- ('Python'),
-- ('AI');


INSERT INTO users (username, email, password_hash, bio, profile_picture_url) VALUES
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Senior Web Developer with 10 years of experience', 'profiles/john.jpg'),
('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Full Stack Developer and AI enthusiast', 'profiles/jane.jpg'),
('mike_wilson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'DevOps Engineer and Cloud Architect', 'profiles/mike.jpg');

-- 2. Then insert categories
INSERT INTO categories (name) VALUES
('Web Development'),
('Mobile Development'),
('DevOps'),
('Data Science'),
('Artificial Intelligence');

-- 3. Then insert tags
INSERT INTO tags (name) VALUES
('DevOps'),
('Python'),
('AI');


-- 5. Finally, insert article tags
INSERT INTO article_tags (article_id, tag_id)
SELECT a.id, t.id
FROM articles a, tags t
WHERE a.slug = 'getting-started-with-react-hooks'
AND t.name IN ('JavaScript', 'React', 'Web Development');

-- Verify the data
SELECT 
    a.title,
    u.username as author,
    c.name as category,
    GROUP_CONCAT(t.name) as tags
FROM articles a
JOIN users u ON a.author_id = u.id
JOIN categories c ON a.category_id = c.id
LEFT JOIN article_tags at ON a.id = at.article_id
LEFT JOIN tags t ON at.tag_id = t.id
GROUP BY a.id;



INSERT INTO articles (
    title,
    slug,
    content,
    excerpt,
    meta_description,
    category_id,
    featured_image,
    author_id
) VALUES 
(
    'Premier Article',
    'premier-article',
    'Contenu du premier article...',
    'Résumé du premier article',
    'Description méta du premier article',
    1,
    '/uploads/article1.jpg',
    2
),
(
    'Deuxième Article',
    'deuxieme-article',
    'Contenu du deuxième article...',
    'Résumé du deuxième article',
    'Description méta du deuxième article',
    2,
    '/uploads/article2.jpg',
    2
),
(
    'Article Programmé',
    'article-programme',
    'Contenu de l\'article programmé...',
    'Résumé de l\'article programmé',
    'Description méta de l\'article programmé',
    6,
    '/uploads/article3.jpg',
    2
);

ALTER TABLE articles
DROP FOREIGN KEY fk_articles_category;

ALTER TABLE articles
ADD CONSTRAINT fk_articles_category
FOREIGN KEY (category_id) REFERENCES categories(id)
ON DELETE CASCADE;