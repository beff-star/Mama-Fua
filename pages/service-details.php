<?php require_once '../config.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare('SELECT * FROM services WHERE slug = ? LIMIT 1');
$stmt->execute([$slug]);
$service = $stmt->fetch();
if (!$service) {
    die('Service not found.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($service['name']) ?> | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .detail-page { max-width: 1000px; margin: 2rem auto; padding: 2rem; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    .detail-banner { height: 260px; background: linear-gradient(135deg,var(--primary),var(--secondary)); border-radius:20px; margin-bottom:1rem; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell">
    <section class="page-card detail-page">
      <div class="detail-banner"></div>
      <h1><?= e($service['name']) ?></h1>
      <p><?= e($service['description']) ?></p>
      <p><strong>Price:</strong> KES <?= number_format($service['price'], 0) ?></p>
      <p><strong>Estimated Duration:</strong> <?= e($service['duration']) ?></p>
      <a class="btn btn-primary" href="services.php">Book Service</a>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
