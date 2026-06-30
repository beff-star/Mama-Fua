<?php
if (!defined('BASE_URL')) {
    exit;
}
$navLinks = [
    'Home' => site_url('/index.php'),
    'About' => site_url('/pages/about.php'),
    'Services' => site_url('/pages/services.php'),
    'Pricing' => site_url('/pages/pricing.php'),
    'Contact' => site_url('/pages/contact.php'),
];
?>
<header class="site-header">
  <div class="header-inner">
    <div class="brand-group">
      <a class="site-logo" href="<?= e(site_url('/index.php')) ?>">Mama Fua</a>
      <p class="site-tagline">Clean homes, happy communities.</p>
    </div>
    <nav class="header-nav" aria-label="Primary navigation">
      <?php foreach ($navLinks as $label => $url): ?>
        <a href="<?= e($url) ?>" class="<?= is_active_link($url) ? 'active' : '' ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="header-cta">
      <?php if (is_logged_in()): ?>
        <a class="btn btn-secondary" href="<?= e(site_url('/pages/dashboard.php')) ?>">Dashboard</a>
        <a class="btn btn-outline" href="<?= e(site_url('/auth/logout.php')) ?>">Logout</a>
      <?php else: ?>
        <a class="btn btn-primary" href="<?= e(site_url('/auth/login.php')) ?>">Login</a>
      <?php endif; ?>
    </div>
  </div>
</header>
