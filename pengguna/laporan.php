<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "pengguna") {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$query = "
    SELECT c.*, l.nama_lokasi, u.username 
    FROM checklists c
    JOIN locations l ON c.lokasi_id = l.id
    JOIN users u ON c.user_id = u.id
    WHERE c.user_id = ?
    ORDER BY c.tanggal DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Checklist Saya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css-img/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h3 class="text-center text-primary fw-bold mb-4">Laporan Checklist Saya</h3>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-success text-center">
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Lokasi</th>
          <th>Petugas</th>
          <th>Sabun</th>
          <th>Tisu</th>
          <th>Air</th>
          <th>Tidak Bau</th>
          <th>Lantai Bersih</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td class="text-center"><?= $no++ ?></td>
          <td><?= date("d/m/Y H:i", strtotime($row['tanggal'])) ?></td>
          <td><?= $row['nama_lokasi'] ?></td>
          <td><?= $row['username'] ?></td>
          <td class="text-center"><?= $row['sabun'] ? '✔' : '❌' ?></td>
          <td class="text-center"><?= $row['tisu'] ? '✔' : '❌' ?></td>
          <td class="text-center"><?= $row['air'] ? '✔' : '❌' ?></td>
          <td class="text-center"><?= $row['bau'] ? '✔' : '❌' ?></td>
          <td class="text-center"><?= $row['lantai'] ? '✔' : '❌' ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-outline-primary rounded-pill">← Kembali ke Dashboard</a>
  </div>
</div>

</body>
</html>