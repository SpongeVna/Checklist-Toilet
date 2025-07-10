<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

// Header agar browser mengunduh file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Checklist_".date("Y-m-d").".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Query data
$query = "
    SELECT c.*, u.username, l.nama_lokasi 
    FROM checklists c
    JOIN users u ON c.user_id = u.id
    JOIN locations l ON c.lokasi_id = l.id
    ORDER BY c.tanggal DESC
";

$result = $conn->query($query);
?>

<table border="1">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Pengguna</th>
            <th>Sabun</th>
            <th>Tisu</th>
            <th>Air</th>
            <th>Bau</th>
            <th>Lantai</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['nama_lokasi'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['sabun'] ? 'Ya' : 'Tidak' ?></td>
            <td><?= $row['tisu'] ? 'Ya' : 'Tidak' ?></td>
            <td><?= $row['air'] ? 'Ya' : 'Tidak' ?></td>
            <td><?= $row['bau'] ? 'Ya' : 'Tidak' ?></td>
            <td><?= $row['lantai'] ? 'Ya' : 'Tidak' ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>