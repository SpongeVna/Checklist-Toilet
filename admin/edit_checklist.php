<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
echo "ID yang diterima: " . $id . "<br>";
var_dump($id);


// Ambil data checklist
$stmt = $conn->prepare("SELECT * FROM checklists WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sabun = isset($_POST["sabun"]) ? 1 : 0;
    $tisu = isset($_POST["tisu"]) ? 1 : 0;
    $air = isset($_POST["air"]) ? 1 : 0;
    $bau = isset($_POST["bau"]) ? 1 : 0;
    $lantai = isset($_POST["lantai"]) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE checklists SET sabun=?, tisu=?, air=?, bau=?, lantai=? WHERE id=?");
    $stmt->bind_param("iiiiii", $sabun, $tisu, $air, $bau, $lantai, $id);
    if ($stmt->execute()) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Checklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm p-4">
            <h4 class="text-center mb-4 text-warning fw-bold">Edit Checklist Toilet</h4>

            <?php if ($success): ?>
                <div class="alert alert-success text-center">Checklist berhasil diperbarui!</div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Checklist Kelengkapan</label>
                    <?php
                    $checklistItems = [
                        'sabun' => 'Sabun',
                        'tisu' => 'Tisu',
                        'air' => 'Air',
                        'bau' => 'Tidak Bau',
                        'lantai' => 'Lantai Bersih'
                    ];
                    foreach ($checklistItems as $key => $label): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="<?= $key ?>" id="<?= $key ?>" <?= $data[$key] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="<?= $key ?>"><?= $label ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-warning rounded-pill">💾 Simpan Perubahan</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="laporan.php" class="text-decoration-none">&larr; Kembali ke Laporan</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
