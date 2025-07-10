<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $role     = $_POST["role"];

    if ($username && $password && $role) {
        // Cek apakah username sudah dipakai
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hash, $role);

            if ($stmt->execute()) {
                $success = true;
            } else {
                $error = "Gagal menambahkan akun.";
            }
        }
    } else {
        $error = "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="col-md-6 offset-md-3">
    <div class="card shadow-sm p-4">
      <h4 class="mb-3 fw-bold text-success text-center">Tambah Akun Baru</h4>

      <?php if ($success): ?>
        <div class="alert alert-success text-center">Akun berhasil ditambahkan!</div>
      <?php elseif ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="pengguna">Pengguna</option>
          </select>
        </div>

        <div class="d-grid">
          <button class="btn btn-success rounded-pill">💾 Simpan Akun</button>
        </div>
      </form>

      <div class="text-center mt-4">
        <a href="users.php" class="text-decoration-none">&larr; Kembali ke Manajemen Akun</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>