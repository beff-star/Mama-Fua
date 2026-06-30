<?php require_once '../config.php'; require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = strtolower(str_replace(' ', '-', $name));
    $description = trim($_POST['description'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $duration = trim($_POST['duration'] ?? '1 hour');
    $stmt = $pdo->prepare('INSERT INTO services (name, slug, description, short_description, price, duration, featured) VALUES (?, ?, ?, ?, ?, ?, 1)');
    $stmt->execute([$name, $slug, $description, $short_description, $price, $duration]);
    $success = 'Service added.';
}

$stmt = $pdo->query('SELECT * FROM services ORDER BY id DESC');
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Services | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .admin-shell { max-width: 1200px; margin: 2rem auto; padding: 2rem; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    form { display:grid; gap:.8rem; margin-bottom:1.5rem; }
    input, textarea { width:100%; padding:.8rem 1rem; border:1px solid #ddd; border-radius:12px; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:.8rem; border-bottom:1px solid #eee; }
  </style>
</head>
<body>
  <div class="admin-shell">
    <h1>Manage Services</h1>
    <?php if (!empty($success)): ?><p style="color:var(--success)"><?= e($success) ?></p><?php endif; ?>
    <form method="post">
      <input type="text" name="name" placeholder="Service name" required>
      <textarea name="description" placeholder="Description" required></textarea>
      <textarea name="short_description" placeholder="Short description"></textarea>
      <input type="number" name="price" step="0.01" placeholder="Price" required>
      <input type="text" name="duration" placeholder="Duration" value="1 hour">
      <button class="btn btn-primary" type="submit">Add Service</button>
    </form>
    <table>
      <thead><tr><th>Name</th><th>Price</th><th>Duration</th></tr></thead>
      <tbody>
        <?php foreach ($services as $service): ?>
          <tr><td><?= e($service['name']) ?></td><td>KES <?= number_format($service['price'], 0) ?></td><td><?= e($service['duration']) ?></td></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
