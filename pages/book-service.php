<?php require_once '../config.php'; require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token.';
    } else {
        $serviceId = (int)($_POST['service_id'] ?? 0);
        $bookingDate = trim($_POST['booking_date'] ?? '');
        $bookingTime = trim($_POST['booking_time'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $paymentMethod = trim($_POST['payment_method'] ?? 'cash_on_delivery');

        $stmt = $pdo->prepare('SELECT price FROM services WHERE id = ? LIMIT 1');
        $stmt->execute([$serviceId]);
        $service = $stmt->fetch();

        if (!$service) {
            $error = 'Please choose a valid service.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO bookings (user_id, service_id, booking_date, booking_time, address, notes, payment_method, payment_status, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, "pending", ?)');
            $stmt->execute([$_SESSION['user_id'], $serviceId, $bookingDate, $bookingTime, $address, $notes, $paymentMethod, $service['price']]);
            $bookingId = $pdo->lastInsertId();
            $pdo->prepare('INSERT INTO payments (booking_id, payment_method, amount, status) VALUES (?, ?, ?, "pending")')->execute([$bookingId, $paymentMethod, $service['price']]);
            $success = 'Booking submitted successfully. Our team will confirm it shortly.';
        }
    }
}

$stmt = $pdo->query('SELECT * FROM services ORDER BY name');
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Service | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .booking-page { max-width: 900px; margin: 2rem auto; padding: 2rem; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    form { display:grid; gap:1rem; }
    select, input, textarea { width:100%; padding:.85rem 1rem; border:1px solid #ddd; border-radius:12px; }
  </style>
</head>
<body>
  <div class="booking-page">
    <h1>Book a Service</h1>
    <?php if (!empty($success)): ?><p style="color:var(--success)"><?= e($success) ?></p><?php endif; ?>
    <?php if (!empty($error)): ?><p style="color:var(--danger)"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
      <?= csrf_field() ?>
      <select name="service_id" required>
        <option value="">Select a service</option>
        <?php foreach ($services as $service): ?>
          <option value="<?= (int)$service['id'] ?>"><?= e($service['name']) ?> - KES <?= number_format($service['price'], 0) ?></option>
        <?php endforeach; ?>
      </select>
      <input type="date" name="booking_date" required>
      <input type="time" name="booking_time" required>
      <input type="text" name="address" placeholder="Service address" required>
      <textarea name="notes" rows="4" placeholder="Any special instructions?"></textarea>
      <select name="payment_method">
        <option value="cash_on_delivery">Cash on Delivery</option>
        <option value="mpesa">M-Pesa</option>
        <option value="paypal">PayPal</option>
        <option value="bank_transfer">Bank Transfer</option>
      </select>
      <button class="btn btn-primary" type="submit">Confirm Booking</button>
    </form>
  </div>
</body>
</html>
