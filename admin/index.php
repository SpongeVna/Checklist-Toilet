<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/css-img/style.css" rel="stylesheet">

  <style>
    body.dark-mode {
      background-color: #121212;
      color: #f1f1f1;
    }
    body.dark-mode .card {
      background-color: #1e1e1e;
      border-color: #333;
    }
    .toggle-switch {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 999;
    }
  </style>
</head>
<body class="bg-light">

<!-- DARK MODE TOGGLE -->
<div class="toggle-switch">
  <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="darkToggle">
    <label class="form-check-label" for="darkToggle">🌙 Mode Gelap</label>
  </div>
</div>

<div class="container py-5">
  <div class="text-center mb-5">
    <img src="../assets/img/2 (1).png" width="80" class="mb-3">
    <h2 class="fw-bold text-primary">Halo Admin, <?= $_SESSION["username"] ?> 🎩</h2>
    <p class="text-muted">Kelola checklist, lokasi, pengguna, dan laporan sistem toilet.</p>
  </div>

  <div class="row justify-content-center g-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm p-4 rounded-4 text-center">
        <i class="bi bi-map-fill fs-2 text-warning"></i>
        <h5 class="mt-3">Kelola Lokasi</h5>
        <a href="lokasi.php" class="btn btn-warning rounded-pill mt-2 w-100">📍 Kelola Lokasi</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm p-4 rounded-4 text-center">
        <i class="bi bi-bar-chart-fill fs-2 text-success"></i>
        <h5 class="mt-3">Laporan Checklist</h5>
        <a href="laporan.php" class="btn btn-success rounded-pill mt-2 w-100">📊 Lihat Laporan</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm p-4 rounded-4 text-center">
        <i class="bi bi-person-lines-fill fs-2 text-secondary"></i>
        <h5 class="mt-3">Kelola User</h5>
        <a href="users.php" class="btn btn-secondary rounded-pill mt-2 w-100">👥 Data Pengguna</a>
      </div>
    </div>
  </div>

  <div class="text-center mt-5">
    <a href="../logout.php" class="btn btn-outline-danger rounded-pill">🚪 Logout</a>
  </div>
</div>

<script>
const toggle = document.getElementById("darkToggle");
const body = document.body;

if (localStorage.getItem("darkMode") === "enabled") {
  body.classList.add("dark-mode");
  toggle.checked = true;
}

toggle.addEventListener("change", () => {
  if (toggle.checked) {
    body.classList.add("dark-mode");
    localStorage.setItem("darkMode", "enabled");
  } else {
    body.classList.remove("dark-mode");
    localStorage.setItem("darkMode", "disabled");
  }
});
</script>

</body>
</html>