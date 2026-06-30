<?php require_once '../config.php';
$stmt = $pdo->query('SELECT s.*, c.name AS category_name FROM services s LEFT JOIN categories c ON c.id = s.category_id ORDER BY s.id DESC');
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .page { max-width: 1200px; margin: 2rem auto; padding: 2rem; }
    .service-list { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:1.5rem; }
    .service-item { background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    .service-item .card-body { padding:1rem 1.2rem 1.3rem; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell">
    <section class="page-card">
      <div class="page-title-section">
        <h1>Our Services</h1>
        <p>Book trusted cleaning services with flexible scheduling.</p>
        <p>Want to see our package pricing? <a href="pricing.php">View pricing details</a> on this page.</p>
      </div>
      <div class="service-list">
      <?php foreach ($services as $service): ?>
        <article class="service-item">
          <div class="card-image"></div>
          <div class="card-body">
            <h3><?= e($service['name']) ?></h3>
            <p><?= e($service['short_description']) ?></p>
            <p><strong>Category:</strong> <?= e($service['category_name'] ?? 'General') ?></p>
            <p><strong>Price:</strong> KES <?= number_format($service['price'], 0) ?></p>
            <p><strong>Duration:</strong> <?= e($service['duration']) ?></p>
            <a class="btn btn-primary" href="service-details.php?slug=<?= e($service['slug']) ?>">View Details</a>
          </div>
        </article>
      <?php endforeach; ?>
      </div>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
