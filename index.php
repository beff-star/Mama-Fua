<?php require_once 'config.php';
$stmt = $pdo->query('SELECT * FROM services WHERE featured = 1 ORDER BY id DESC LIMIT 6');
$featuredServices = $stmt->fetchAll();
$stmt = $pdo->query('SELECT * FROM blogs ORDER BY id DESC LIMIT 3');
$blogs = $stmt->fetchAll();
$stmt = $pdo->query('SELECT * FROM settings LIMIT 1');
$settings = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($settings['seo_title'] ?? 'Mama Fua Services') ?></title>
  <meta name="description" content="<?= e($settings['seo_description'] ?? 'Professional cleaning services in Umoja and beyond.') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <?php include_header(); ?>
  <main>
    <section class="hero">
      <div class="hero-content">
        <p class="eyebrow">Cleanliness is next to Godliness</p>
        <h1>Professional cleaning services at an affordable price.</h1>
        <p>From household cleaning to laundry pickup and delivery, our trusted team keeps every space spotless.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="pages/services.php">Book Now</a>
          <a class="btn btn-secondary" href="pages/about.php">Explore Services</a>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="section-heading">
        <p class="eyebrow">Featured Services</p>
        <h2>Choose the service that fits your space</h2>
      </div>
      <div class="grid services-grid">
        <?php foreach ($featuredServices as $service): ?>
          <article class="card service-card">
            <div class="card-image"></div>
            <div class="card-body">
              <h3><?= e($service['name']) ?></h3>
              <p><?= e($service['short_description']) ?></p>
              <div class="service-meta">
                <span><i class="fa-solid fa-tag"></i> KES <?= number_format($service['price'], 0) ?></span>
                <span><i class="fa-solid fa-star"></i> 4.9</span>
              </div>
              <a class="btn btn-primary" href="pages/service-details.php?slug=<?= e($service['slug']) ?>">Book Now</a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section alt-section">
      <div class="section-heading">
        <p class="eyebrow">Why Choose Us</p>
        <h2>Trusted by households and businesses alike</h2>
      </div>
      <div class="grid features-grid">
        <?php foreach (['Affordable Prices','Professional Cleaners','Trusted Staff','Flexible Scheduling','Secure Payments','Same-Day Service','Quality Guarantee'] as $feature): ?>
          <div class="feature-card"><h3><?= e($feature) ?></h3><p>Premium support with dependable service and transparent pricing.</p></div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section">
      <div class="section-heading">
        <p class="eyebrow">Latest from the Blog</p>
        <h2>Cleaning tips and practical guidance</h2>
      </div>
      <div class="grid blog-grid">
        <?php foreach ($blogs as $blog): ?>
          <article class="card blog-card">
            <div class="card-body">
              <h3><?= e($blog['title']) ?></h3>
              <p><?= e(substr(strip_tags($blog['content']), 0, 120)) ?>...</p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
