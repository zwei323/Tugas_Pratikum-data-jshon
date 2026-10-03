<?php
/**
 * api.php — backend sederhana untuk data_user.html
 * Penyimpanan data: users.json (di folder yang sama)
 *
 * Endpoint:
 *   GET    api.php            -> ambil semua user (array JSON)
 *   POST   api.php            -> tambah user baru (body JSON: nama/name, email, street, suite, city, zipcode)
 *   PUT    api.php            -> update user (body JSON wajib berisi "id")
 *   DELETE api.php?id=123     -> hapus user berdasarkan id
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Preflight request (kalau frontend & backend beda origin)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$dataFile = __DIR__ . '/users.json';

function bacaData($file) {
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([]));
    }
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function simpanData($file, $data) {
    // JSON_PRETTY_PRINT biar file mudah dibaca manual, JSON_UNESCAPED_UNICODE biar nama dgn karakter khusus aman
    return file_put_contents(
        $file,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    ) !== false;
}

function balasError($pesan, $status = 400) {
    http_response_code($status);
    echo json_encode(["message" => $pesan]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$users = bacaData($dataFile);

switch ($method) {

    case 'GET':
        // Kembalikan semua data user sebagai array JSON
        http_response_code(200);
        echo json_encode($users);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            balasError("Body request tidak valid / bukan JSON", 400);
        }

        $nama = trim($input['nama'] ?? $input['name'] ?? '');
        $email = trim($input['email'] ?? '');
        if ($nama === '' || $email === '') {
            balasError("Nama dan email wajib diisi", 422);
        }

        $idBaru = 1;
        foreach ($users as $u) {
            if ($u['id'] >= $idBaru) $idBaru = $u['id'] + 1;
        }

        $userBaru = [
            "id" => $idBaru,
            "name" => $nama,
            "email" => $email,
            "address" => [
                "street" => trim($input['street'] ?? ''),
                "suite" => trim($input['suite'] ?? ''),
                "city" => trim($input['city'] ?? ''),
                "zipcode" => trim($input['zipcode'] ?? '')
            ]
        ];

        $users[] = $userBaru;

        if (!simpanData($dataFile, $users)) {
            balasError("Gagal menyimpan data ke server", 500);
        }

        http_response_code(201);
        // Balikan field "nama" juga supaya cocok dengan penanganan di data_user.html
        echo json_encode([
            "id" => $userBaru['id'],
            "nama" => $userBaru['name'],
            "name" => $userBaru['name'],
            "email" => $userBaru['email'],
            "address" => $userBaru['address']
        ]);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['id'])) {
            balasError("ID user wajib disertakan untuk update", 400);
        }

        $id = (int) $input['id'];
        $ditemukan = false;

        foreach ($users as &$u) {
            if ($u['id'] === $id) {
                $u['name'] = trim($input['nama'] ?? $input['name'] ?? $u['name']);
                $u['email'] = trim($input['email'] ?? $u['email']);
                $u['address'] = [
                    "street" => trim($input['street'] ?? $u['address']['street'] ?? ''),
                    "suite" => trim($input['suite'] ?? $u['address']['suite'] ?? ''),
                    "city" => trim($input['city'] ?? $u['address']['city'] ?? ''),
                    "zipcode" => trim($input['zipcode'] ?? $u['address']['zipcode'] ?? '')
                ];
                $ditemukan = $u;
                break;
            }
        }
        unset($u);

        if (!$ditemukan) {
            balasError("User dengan id $id tidak ditemukan", 404);
        }

        if (!simpanData($dataFile, $users)) {
            balasError("Gagal menyimpan perubahan ke server", 500);
        }

        http_response_code(200);
        echo json_encode([
            "id" => $ditemukan['id'],
            "nama" => $ditemukan['name'],
            "name" => $ditemukan['name'],
            "email" => $ditemukan['email'],
            "address" => $ditemukan['address']
        ]);
        break;

    case 'DELETE':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if ($id === null) {
            balasError("Parameter id wajib disertakan (?id=...)", 400);
        }

        $jumlahAwal = count($users);
        $users = array_values(array_filter($users, fn($u) => $u['id'] !== $id));

        if (count($users) === $jumlahAwal) {
            balasError("User dengan id $id tidak ditemukan", 404);
        }

        if (!simpanData($dataFile, $users)) {
            balasError("Gagal menghapus data di server", 500);
        }

        http_response_code(200);
        echo json_encode(["message" => "User berhasil dihapus"]);
        break;

    default:
        balasError("Method tidak didukung", 405);
}