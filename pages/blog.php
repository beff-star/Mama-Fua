<?php require_once '../config.php';
$stmt = $pdo->query('SELECT * FROM blogs ORDER BY id DESC');
$blogs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .blog-page { max-width: 1100px; margin: 2rem auto; padding: 2rem; }
    .blog-post { background:#fff; border-radius:20px; padding:1.25rem; box-shadow:0 20px 40px rgba(0,0,0,.08); margin-bottom:1rem; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell">
    <section class="page-card blog-page">
      <div class="page-title-section">
        <h1>Cleaning Tips & Insights</h1>
      </div>
      <?php foreach ($blogs as $blog): ?>
        <article class="blog-post">
          <h2><?= e($blog['title']) ?></h2>
          <p><strong>Author:</strong> <?= e($blog['author']) ?> | <strong>Category:</strong> <?= e($blog['category']) ?></p>
          <p><?= e(substr(strip_tags($blog['content']), 0, 220)) ?>...</p>
        </article>
      <?php endforeach; ?>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
