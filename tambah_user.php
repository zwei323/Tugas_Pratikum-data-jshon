<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../koneksi.php";

// Ambil data JSON yang dikirim dari fetch()
$data = json_decode(file_get_contents("php://input"), true);

$name     = trim($data["name"] ?? "");
$username = trim($data["username"] ?? "");
$email    = trim($data["email"] ?? "");
$phone    = trim($data["phone"] ?? "");
$website  = trim($data["website"] ?? "");

// ---------- VALIDASI ----------
if ($name === "" || $username === "" || $email === "") {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Nama, username, dan email wajib diisi."
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Format email tidak valid."
    ]);
    exit;
}

// ---------- CEK DUPLIKAT (username & email harus UNIQUE) ----------
$cek = mysqli_prepare($koneksi, "SELECT id FROM users WHERE username = ? OR email = ?");
mysqli_stmt_bind_param($cek, "ss", $username, $email);
mysqli_stmt_execute($cek);
$hasilCek = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($hasilCek) > 0) {
    http_response_code(409);
    echo json_encode([
        "success" => false,
        "message" => "Username atau email sudah dipakai. Gunakan yang lain."
    ]);
    exit;
}
mysqli_stmt_close($cek);

// ---------- INSERT ----------
// company_id dibiarkan NULL karena form tidak meminta data perusahaan
$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO users (name, username, email, phone, website, company_id) VALUES (?, ?, ?, ?, ?, NULL)"
);
mysqli_stmt_bind_param($stmt, "sssss", $name, $username, $email, $phone, $website);

if (mysqli_stmt_execute($stmt)) {
    $id_baru = mysqli_insert_id($koneksi);
    echo json_encode([
        "success" => true,
        "message" => "Data berhasil disimpan ke database.",
        "data" => [
            "id" => $id_baru,
            "name" => $name,
            "username" => $username,
            "email" => $email,
            "phone" => $phone,
            "website" => $website
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan data: " . mysqli_error($koneksi)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);