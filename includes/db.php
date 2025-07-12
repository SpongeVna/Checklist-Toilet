<?php
$host = "metro.proxy.rlwy.net";
$port = 56793;
$user = "root";
$pass = "KFRuhiVOImdekJHBZNfqLCPNSxGSjitG";
$db   = "railway";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
