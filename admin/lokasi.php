<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

// Tambah lokasi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nama_lokasi"])) {
    $nama = trim($_POST["nama_lokasi"]);
    if (!empty($nama)) {
        $stmt = $conn->prepare("INSERT INTO locations (nama_lokasi) VALUES (?)");
        $stmt->bind_param("s", $nama);
        $stmt->execute();
    }
    header("Location: lokasi.php");
    exit;
}

// Hapus lokasi
if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    $stmt = $conn->prepare("DELETE FROM locations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: lokasi.php");
    exit;
}

$lokasiResult = $conn->query("SELECT * FROM locations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Lokasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap + Custom -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css-img/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    Tambah Lokasi Toilet
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" placeholder="Contoh: Toilet Lantai 1" required>
                        </div>
                        <button type="submit" class="btn btn-success rounded-pill">➕ Tambah</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white fw-bold">
                    Daftar Lokasi Toilet
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = $lokasiResult->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row["nama_lokasi"]) ?></td>
                                <td class="text-center">
                                    <a href="?hapus=<?= $row["id"] ?>" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus lokasi ini?')">🗑 Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if ($lokasiResult->num_rows === 0): ?>
                            <tr><td colspan="3" class="text-center text-muted">Belum ada lokasi</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>