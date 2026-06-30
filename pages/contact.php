<?php require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([trim($_POST['name'] ?? ''), trim($_POST['email'] ?? ''), trim($_POST['phone'] ?? ''), trim($_POST['message'] ?? '')]);
        $success = 'Thank you for contacting us. We will reach out soon.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .contact-page { max-width: 1100px; margin: 2rem auto; padding: 2rem; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    form { display:grid; gap:.8rem; }
    input, textarea { width:100%; padding:.85rem 1rem; border:1px solid #ddd; border-radius:12px; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell">
    <section class="page-card contact-page">
      <div class="page-title-section">
        <h1>Contact Us</h1>
        <p>Call or email us anytime. We are available Monday to Saturday, 8:00 AM to 5:00 PM.</p>
      </div>
      <p><strong>Phone:</strong> 0743468419</p>
      <p><strong>Email:</strong> befrineclaire@gmail.com</p>
      <p><strong>Address:</strong> Umoja, Nairobi</p>
      <?php if (!empty($success)): ?><p style="color:var(--success)"><?= e($success) ?></p><?php endif; ?>
      <form method="post">
      <?= csrf_field() ?>
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <input type="text" name="phone" placeholder="Phone Number">
      <textarea name="message" rows="5" placeholder="Your message" required></textarea>
      <button class="btn btn-primary" type="submit">Send Message</button>
    </form>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
