<?php
if (!defined('BASE_URL')) {
    exit;
}
?>
<footer class="site-footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <a class="footer-logo" href="<?= e(site_url('/index.php')) ?>">Mama Fua</a>
      <p>Trusted cleaning services for homes, offices, and rentals across Umoja and Nairobi.</p>
    </div>
    <div class="footer-column">
      <h3>Quick Links</h3>
      <a href="<?= e(site_url('/pages/about.php')) ?>">About Us</a>
      <a href="<?= e(site_url('/pages/services.php')) ?>">Our Services</a>
      <a href="<?= e(site_url('/pages/pricing.php')) ?>">Pricing</a>
      <a href="<?= e(site_url('/pages/contact.php')) ?>">Contact</a>
    </div>
    <div class="footer-column">
      <h3>Contact</h3>
      <p>Umoja, Nairobi</p>
      <p>0743 468 419</p>
      <p><a href="mailto:befrineclaire@gmail.com">befrineclaire@gmail.com</a></p>
    </div>
    <div class="footer-column">
      <h3>Hours</h3>
      <p>Mon - Sat: 8:00 AM - 6:00 PM</p>
      <p>Sunday: Closed</p>
      <p>Same-day scheduling available.</p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?= date('Y') ?> Mama Fua Services. All rights reserved.</p>
    <p>Safe cleaning, dependable service, and local support.</p>
  </div>
</footer>
