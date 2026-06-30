<?php require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            if ($user['role'] === 'admin') {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: ../pages/dashboard.php');
            }
            exit;
        }
        $error = 'Invalid credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Mama Fua Services</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; background:linear-gradient(135deg,#e8f5e9,#fff8e1); }
    .auth-card { width:min(460px,90vw); background:#fff; padding:2rem; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
    .form-group { margin-bottom:1rem; }
    input { width:100%; padding:.85rem 1rem; border:1px solid #ddd; border-radius:12px; }
    .btn { border:none; cursor:pointer; width:100%; text-align:center; }
  </style>
</head>
<body>
  <?php include_header(); ?>
  <main class="page-shell auth-shell">
    <section class="auth-card">
      <h2>Welcome Back</h2>
      <?php if (!empty($error)): ?><p style="color:var(--danger)"><?= e($error) ?></p><?php endif; ?>
      <form method="post">
        <?= csrf_field() ?>
        <div class="form-group"><input type="email" name="email" placeholder="Email" required></div>
        <div class="form-group"><input type="password" name="password" placeholder="Password" required></div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
      <p style="margin-top:1rem;"><a href="register.php">Create an account</a></p>
    </section>
  </main>
  <?php include_footer(); ?>
</body>
</html>
