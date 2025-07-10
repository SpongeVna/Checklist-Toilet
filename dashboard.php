<?php
include 'includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="text-end">
    <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
  </div>
  <h1 class="mb-4">Halo, <?= ucfirst($_SESSION["role"]); ?> 👋</h1>
  
  <?php if (isAdmin()): ?>
    <a href="admin/lokasi.php" class="btn btn-primary">Kelola Lokasi</a>
    <a href="admin/laporan.php" class="btn btn-success">Lihat Laporan</a>
  <?php else: ?>
    <a href="user/checklist.php" class="btn btn-primary">Isi Checklist</a>
  <?php endif; ?>
</div>
</body>
</html>