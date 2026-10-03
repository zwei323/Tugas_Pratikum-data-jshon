<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../koneksi.php";

$hasil = mysqli_query($koneksi, "SELECT id, name, username, email, phone, website, company_id FROM users ORDER BY id ASC");

$daftar = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $daftar[] = $baris;
}

echo json_encode($daftar);

mysqli_close($koneksi);