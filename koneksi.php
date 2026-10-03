<?php
// ================== KONFIGURASI DATABASE ==================
// Sesuaikan jika setting XAMPP/Laragon kamu berbeda
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "zwei1";
$DB_NAME = "belajar_api";
// =============================================================

$koneksi = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$koneksi) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode([
        "success" => false,
        "message" => "Koneksi database gagal: " . mysqli_connect_error()
    ]);
    exit;
}

mysqli_set_charset($koneksi, "utf8mb4");