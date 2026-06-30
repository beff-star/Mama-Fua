<?php require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token.';
    } else {
        $fullName = trim($_POST['full_name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email.';
        } elseif (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters.';
        } else {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
            $stmt->execute([$email, $username]);
            if ($stmt->fetch()) {
                $error = 'Email or username already exists.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (full_name, username, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, "customer")');
                $stmt->execute([$fullName, $username, $email, $phone, $hash]);
                $_SESSION['success'] = 'Registration successful. Please login.';
                header('Location: login.php');
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; background:linear-gradient(135deg,#e8f5e9,#fff8e1); }
    .auth-card { width:min(520px,90vw); background:#fff; padding:2rem; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    .form-group { margin-bottom:1rem; }
    input { width:100%; padding:.85rem 1rem; border:1px solid #ddd; border-radius:12px; }
    .btn { border:none; cursor:pointer; width:100%; text-align:center; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell auth-shell">
    <section class="auth-card">
      <h2>Create Your Account</h2>
      <?php if (!empty($error)): ?><p style="color:var(--danger)"><?= e($error) ?></p><?php endif; ?>
      <form method="post">
        <?= csrf_field() ?>
        <div class="form-group"><input type="text" name="full_name" placeholder="Full Name" required></div>
        <div class="form-group"><input type="text" name="username" placeholder="Username" required></div>
        <div class="form-group"><input type="email" name="email" placeholder="Email" required></div>
        <div class="form-group"><input type="text" name="phone" placeholder="Phone"></div>
        <div class="form-group"><input type="password" name="password" placeholder="Password" required></div>
        <div class="form-group"><input type="password" name="confirm_password" placeholder="Confirm Password" required></div>
        <button class="btn btn-primary" type="submit">Register</button>
      </form>
      <p style="margin-top:1rem;"><a href="login.php">Already have an account?</a></p>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
