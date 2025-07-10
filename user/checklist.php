<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isPengguna()) {
    header("Location: ../dashboard.php");
    exit;
}

// Ambil data lokasi
$locations = $conn->query("SELECT * FROM locations");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $location_id = $_POST['location_id'];
    $tanggal = date('Y-m-d');
    $waktu = date('H:i:s');

    $checklist_items = [
        "air_mengalir" => isset($_POST["air_mengalir"]) ? 1 : 0,
        "sabun_ada" => isset($_POST["sabun_ada"]) ? 1 : 0,
        "lantai_bersih" => isset($_POST["lantai_bersih"]) ? 1 : 0,
        "bau_tidak_sedap" => isset($_POST["bau_tidak_sedap"]) ? 1 : 0
    ];

    $data = json_encode($checklist_items);

    $stmt = $conn->prepare("INSERT INTO checklists (user_id, location_id, tanggal_check, waktu_check, checklist_data) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $location_id, $tanggal, $waktu, $data);
    $stmt->execute();

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Checklist Toilet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Form Checklist Toilet</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success">Checklist berhasil disimpan!</div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="location_id" class="form-label">Pilih Lokasi Toilet</label>
            <select name="location_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php while ($row = $locations->fetch_assoc()): ?>
                    <option value="<?= $row['id']; ?>"><?= $row['nama_lokasi']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Checklist:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="air_mengalir" id="air_mengalir">
                <label class="form-check-label" for="air_mengalir">Air Mengalir</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sabun_ada" id="sabun_ada">
                <label class="form-check-label" for="sabun_ada">Sabun Tersedia</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="lantai_bersih" id="lantai_bersih">
                <label class="form-check-label" for="lantai_bersih">Lantai Bersih</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="bau_tidak_sedap" id="bau_tidak_sedap">
                <label class="form-check-label" for="bau_tidak_sedap">Tidak Ada Bau Tidak Sedap</label>
            </div>
        </div>

        <button class="btn btn-primary">Simpan Checklist</button>
    </form>
</div>
</body>
</html>