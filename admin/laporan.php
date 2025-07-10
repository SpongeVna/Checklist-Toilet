<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$query = "
    SELECT c.*, u.username, l.nama_lokasi 
    FROM checklists c
    JOIN users u ON c.user_id = u.id
    JOIN locations l ON c.lokasi_id = l.id
    ORDER BY c.tanggal DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Checklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Custom -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css-img/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary fw-bold">Laporan Checklist Toilet</h3>
        <a href="export_excel.php" class="btn btn-success rounded-pill">⬇ Export ke Excel</a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary text-center">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle text-center">
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($row['tanggal'])) ?></td>
                    <td><?= $row['nama_lokasi'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['sabun'] ? '✔️' : '❌' ?></td>
                    <td><?= $row['tisu'] ? '✔️' : '❌' ?></td>
                    <td><?= $row['air'] ? '✔️' : '❌' ?></td>
                    <td><?= $row['bau'] ? '✔️' : '❌' ?></td>
                    <td><?= $row['lantai'] ? '✔️' : '❌' ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="edit_checklist.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning rounded-pill px-3">✏️</a>
                            <a href="delete_checklist.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>