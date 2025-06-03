<?php
// Database connection (XAMPP default: username = 'root', password = '')
$db = new mysqli('localhost', 'root', '', 'blog_db');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch all posts
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $db->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | WEBSITE VAREL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Basic Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background: #f4f4f4;
        }
        .navbar {
            background: #333;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        .navbar a.active {
            font-weight: bold;
        }
        .blog-page {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .blog-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .blog-post {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .post-badge {
            background: #4CAF50;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .read-more {
            display: inline-block;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
        }
        footer {
            text-align: center;
            padding: 1rem;
            background: #333;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>WEBSITE VAREL</h1>
            <nav>
                <a href="index.html">Home</a>
                <a href="gallery.html">Gallery</a>
                <a href="blog.php" class="active">Blog</a>
                <a href="contact.html">Contact</a>
            </nav>
        </div>
    </header>

    <main class="blog-page">
        <h2>Blog Posts</h2>
        <div class="blog-list">
            <?php while($post = $result->fetch_assoc()): ?>
                <article class="blog-post">
                    <div class="post-header">
                        <a href="<?= $post['link'] ?>" target="_blank"><h3><?= $post['title'] ?></h3></a>
                        <?php if($post['is_new']): ?>
                            <span class="post-badge">New</span>
                        <?php endif; ?>
                    </div>
                    <p><?= $post['excerpt'] ?></p>
                    <a href="<?= $post['link'] ?>" target="_blank" class="read-more">
                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Varel. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $db->close(); ?>