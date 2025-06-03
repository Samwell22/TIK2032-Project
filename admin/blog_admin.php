<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Database connection
$db = new mysqli('localhost', 'username', 'password', 'blog_db');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_post'])) {
        $title = $db->real_escape_string($_POST['title']);
        $content = $db->real_escape_string($_POST['content']);
        $excerpt = $db->real_escape_string($_POST['excerpt']);
        $link = $db->real_escape_string($_POST['link']);
        $is_new = isset($_POST['is_new']) ? 1 : 0;
        
        $query = "INSERT INTO posts (title, content, excerpt, link, is_new) 
                  VALUES ('$title', '$content', '$excerpt', '$link', $is_new)";
        $db->query($query);
    } elseif (isset($_POST['delete_post'])) {
        $id = intval($_POST['post_id']);
        $query = "DELETE FROM posts WHERE id = $id";
        $db->query($query);
    }
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
  <title>Admin Blog | WEBSITE VAREL</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .admin-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 1rem;
    }
    .post-form {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
    }
    .form-group input, 
    .form-group textarea {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .form-group textarea {
      min-height: 150px;
    }
    .post-list {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .post-item {
      padding: 1rem;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .post-actions form {
      display: inline-block;
    }
    .btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-primary {
      background: #4CAF50;
      color: white;
    }
    .btn-danger {
      background: #f44336;
      color: white;
    }
  </style>
</head>
<body>
  <header>
    <div class="navbar">
      <h1>WEBSITE VAREL - Admin</h1>
      <nav>
        <a href="../index.php">Home</a>
        <a href="blog_admin.php">Blog Admin</a>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main class="admin-container">
    <h2>Blog Management</h2>
    
    <section class="post-form">
      <h3>Add New Post</h3>
      <form method="POST">
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
          <label for="content">Content:</label>
          <textarea id="content" name="content" required></textarea>
        </div>
        <div class="form-group">
          <label for="excerpt">Excerpt:</label>
          <textarea id="excerpt" name="excerpt" required></textarea>
        </div>
        <div class="form-group">
          <label for="link">Link:</label>
          <input type="url" id="link" name="link" required>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" name="is_new"> Mark as New
          </label>
        </div>
        <button type="submit" name="add_post" class="btn btn-primary">Add Post</button>
      </form>
    </section>
    
    <section class="post-list">
      <h3>Current Posts</h3>
      <?php if ($result->num_rows > 0): ?>
        <?php while($post = $result->fetch_assoc()): ?>
          <div class="post-item">
            <div class="post-info">
              <h4><?= htmlspecialchars($post['title']) ?></h4>
              <small><?= date('d M Y', strtotime($post['created_at'])) ?></small>
              <?php if($post['is_new']): ?>
                <span class="post-badge">New</span>
              <?php endif; ?>
            </div>
            <div class="post-actions">
              <form method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit" name="delete_post" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No posts found.</p>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p>&copy; <?= date('Y') ?> Varel. All rights reserved.</p>
  </footer>
</body>
</html>
<?php
$db->close();
?>