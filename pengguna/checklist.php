<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "pengguna") {
    header("Location: ../login.php");
    exit;
}

$success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lokasi_id = $_POST["lokasi_id"];
    $user_id = $_SESSION["user_id"];
    $tanggal = date("Y-m-d H:i:s");
    $sabun = isset($_POST["sabun"]) ? 1 : 0;
    $tisu = isset($_POST["tisu"]) ? 1 : 0;
    $air = isset($_POST["air"]) ? 1 : 0;
    $bau = isset($_POST["bau"]) ? 1 : 0;
    $lantai = isset($_POST["lantai"]) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO checklists (user_id, lokasi_id, tanggal, sabun, tisu, air, bau, lantai) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisiiiii", $user_id, $lokasi_id, $tanggal, $sabun, $tisu, $air, $bau, $lantai);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = "Gagal menyimpan checklist.";
    }
}

// ambil lokasi toilet
$lokasiResult = $conn->query("SELECT * FROM locations");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checklist Toilet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Custom -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css-img/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm p-4">
                <h3 class="text-center mb-4 text-primary">Checklist Kebersihan Toilet</h3>

                <?php if ($success): ?>
                    <div class="alert alert-success text-center rounded-pill">
                        Checklist berhasil disimpan!
                    </div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger text-center rounded-pill">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="lokasi_id" class="form-label">Pilih Lokasi Toilet</label>
                        <select name="lokasi_id" id="lokasi_id" class="form-select" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <?php while ($lokasi = $lokasiResult->fetch_assoc()): ?>
                                <option value="<?= $lokasi['id'] ?>"><?= $lokasi['nama_lokasi'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Checklist Kelengkapan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sabun" id="sabun">
                            <label class="form-check-label" for="sabun">Sabun</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tisu" id="tisu">
                            <label class="form-check-label" for="tisu">Tisu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="air" id="air">
                            <label class="form-check-label" for="air">Air</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="bau" id="bau">
                            <label class="form-check-label" for="bau">Tidak Bau</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lantai" id="lantai">
                            <label class="form-check-label" for="lantai">Lantai Bersih</label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">Simpan Checklist</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <a href="index.php" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>