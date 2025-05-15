<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION['role'])) {
  header("Location: ../dashboard/" . ($_SESSION['role'] === 'admin' ? "dashboard_admin.php" : "dashboard_user.php"));
  exit();
}


// Cek login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === "admin" && $password === "admin123") {
    $_SESSION['username'] = 'admin';
    $_SESSION['role'] = 'admin';
    header("Location: ../dashboard/dashboard_admin.php");
    exit();
  } elseif ($username === "user" && $password === "user123") {
    $_SESSION['username'] = 'user';
    $_SESSION['role'] = 'user';
    header("Location: ../dashboard/dashboard_user.php");
    exit();
  }
  
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Sistem Pengukur Tinggi Badan</title>
  <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-orange-50 font-sans flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
    <h2 class="text-2xl font-bold text-center mb-6 text-orange-600">Login</h2>

    <?php if (isset($error)): ?>
      <p class="text-red-500 text-sm mb-4"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">Username</label>
        <input type="text" name="username" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"/>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"/>
      </div>
      <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-md font-medium">Login</button>
    </form>
  </div>
</body>
</html>
