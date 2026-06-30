<?php require_once '../config.php'; require_login();
$stmt = $pdo->prepare('SELECT * FROM bookings WHERE user_id = ? ORDER BY id DESC LIMIT 5');
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .dashboard { max-width: 1100px; margin: 2rem auto; padding: 2rem; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    .stats { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; margin-bottom:1.5rem; }
    .stat { padding:1rem; border-radius:16px; background:linear-gradient(135deg,#e8f5e9,#fff8e1); }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:.8rem; border-bottom:1px solid #eee; text-align:left; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell">
    <section class="page-card dashboard">
      <h1>Welcome, <?= e($_SESSION['full_name']) ?>!</h1>
      <p>Manage your bookings and keep track of your service requests.</p>
      <div class="stats">
      <div class="stat"><strong>Upcoming Bookings</strong><div>2</div></div>
      <div class="stat"><strong>Completed Services</strong><div>4</div></div>
      <div class="stat"><strong>Pending Bookings</strong><div>1</div></div>
    </div>
    <h2>Your Recent Bookings</h2>
    <table>
      <thead><tr><th>Service</th><th>Date</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($bookings as $booking): ?>
          <tr>
            <td><?= e($booking['address']) ?></td>
            <td><?= e($booking['booking_date']) ?></td>
            <td><?= e($booking['status']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p style="margin-top:1rem;"><a class="btn btn-primary" href="services.php">Book a Service</a></p>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
