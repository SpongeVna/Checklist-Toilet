<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h3 class="mb-4 fw-bold text-primary">Manajemen Akun</h3>
  <a href="tambah_user.php" class="btn btn-success mb-3 rounded-pill">➕ Tambah Akun</a>

  <table class="table table-bordered">
    <thead class="table-primary text-center">
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td class="text-center"><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td class="text-capitalize"><?= $row['role'] ?></td>
          <td class="text-center">
            <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
            <a href="hapus_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Yakin ingin hapus user ini?')">🗑️ Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="mt-4 text-center">
    <a href="index.php" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
  </div>
</div>
</body>
</html>