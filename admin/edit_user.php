<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User tidak ditemukan.");
}

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $role     = $_POST["role"];
    $password = trim($_POST["password"]);

    if ($username && $role) {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
            $stmt->bind_param("sssi", $username, $hash, $role, $id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
            $stmt->bind_param("ssi", $username, $role, $id);
        }

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Gagal menyimpan perubahan.";
        }
    } else {
        $error = "Username dan role tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="col-md-6 offset-md-3">
    <div class="card shadow-sm p-4">
      <h4 class="mb-3 text-warning fw-bold text-center">Edit Akun</h4>

      <?php if ($success): ?>
        <div class="alert alert-success text-center">Perubahan berhasil disimpan!</div>
      <?php elseif ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
          <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="pengguna" <?= $user['role'] === 'pengguna' ? 'selected' : '' ?>>Pengguna</option>
          </select>
        </div>

        <div class="d-grid">
          <button class="btn btn-warning rounded-pill">💾 Simpan Perubahan</button>
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