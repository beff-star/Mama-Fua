<?php require_once '../config.php'; require_admin();
$stmt = $pdo->query('SELECT COUNT(*) AS count FROM users');
$totalUsers = $stmt->fetch();
$stmt = $pdo->query('SELECT COUNT(*) AS count FROM cleaners');
$totalCleaners = $stmt->fetch();
$stmt = $pdo->query('SELECT COUNT(*) AS count FROM bookings');
$totalBookings = $stmt->fetch();
$stmt = $pdo->query('SELECT COUNT(*) AS count FROM bookings WHERE status = "pending"');
$pendingBookings = $stmt->fetch();
$stmt = $pdo->query('SELECT COALESCE(SUM(total_amount),0) AS total FROM bookings WHERE payment_status = "paid"');
$revenue = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .admin-shell { max-width: 1200px; margin: 2rem auto; padding: 2rem; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    .admin-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; }
    .panel { padding:1rem; border-radius:16px; background:linear-gradient(135deg,#e8f5e9,#fff8e1); }
  </style>
</head>
<body>
  <div class="admin-shell">
    <h1>Admin Dashboard</h1>
    <div class="admin-grid">
      <div class="panel"><strong>Total Users</strong><div><?= (int)$totalUsers['count'] ?></div></div>
      <div class="panel"><strong>Total Cleaners</strong><div><?= (int)$totalCleaners['count'] ?></div></div>
      <div class="panel"><strong>Total Bookings</strong><div><?= (int)$totalBookings['count'] ?></div></div>
      <div class="panel"><strong>Pending Bookings</strong><div><?= (int)$pendingBookings['count'] ?></div></div>
      <div class="panel"><strong>Revenue</strong><div>KES <?= number_format($revenue['total'], 0) ?></div></div>
    </div>
    <p style="margin-top:1rem;"><a class="btn btn-primary" href="services.php">Manage Services</a></p>
  </div>
</body>
</html>
