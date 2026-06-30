<?php require_once '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pricing | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .pricing-page { max-width: 1100px; margin: 2rem auto; padding: 2rem; }
    .pricing-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1.5rem; }
    .pricing-card { background:#fff; border-radius:20px; padding:1.5rem; box-shadow:0 20px 40px rgba(0,0,0,.08); }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell">
    <section class="page-card pricing-page">
      <div class="page-title-section">
        <h1>Pricing Packages</h1>
      </div>
      <div class="pricing-grid">
      <div class="pricing-card"><h3>Basic</h3><p>Essentials for light cleaning.</p><strong>KES 1,500</strong></div>
      <div class="pricing-card"><h3>Standard</h3><p>Ideal for regular homes and offices.</p><strong>KES 2,500</strong></div>
      <div class="pricing-card"><h3>Premium</h3><p>Deep cleaning and detailed finishing.</p><strong>KES 4,500</strong></div>
      <div class="pricing-card"><h3>Custom Quote</h3><p>Tailored packages for larger spaces.</p><strong>On Request</strong></div>
    </div>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
