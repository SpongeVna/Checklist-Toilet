<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "checklist_toilet";

$conn = new mysqli("localhost", "root", "", "checklist_toilet");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>