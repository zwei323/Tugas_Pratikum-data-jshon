<?php
header("Content-Type: application/json");
require_once __DIR__ . "/koneksi1.php";

$hasil = mysqli_query(
    $koneksi,
    "SELECT id, nama, email, street, suite, city, zipcode FROM praktikum-db_users ORDER BY id ASC"
);

if (!$hasil) {
    http_response_code(500);
    echo json_encode(["message" => "Gagal mengambil data: " . mysqli_error($koneksi)]);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($hasil)) {
    $data[] = [
        "id"    => (int)$row["id"],
        "name"  => $row["nama"],
        "email" => $row["email"],
        "address" => [
            "street"  => $row["street"],
            "suite"   => $row["suite"],
            "city"    => $row["city"],
            "zipcode" => $row["zipcode"]
        ]
    ];
}

echo json_encode($data);

mysqli_close($koneksi);