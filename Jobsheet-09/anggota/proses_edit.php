<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit();
}

$id = $_POST['id'] ?? null;
$no_anggota = trim($_POST['no_anggota'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

if (!$id || empty($nama)) {
    $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Nama anggota wajib diisi.'];
    header("Location: edit.php?id=" . urlencode($id));
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE anggota SET no_anggota = :no_anggota, nama = :nama, alamat = :alamat, no_hp = :no_hp WHERE id = :id");
    $stmt->execute([
        ':no_anggota' => $no_anggota,
        ':nama' => $nama,
        ':alamat' => $alamat,
        ':no_hp' => $no_hp,
        ':id' => $id
    ]);

    $_SESSION['flash'] = ['type' => 'sukses', 'pesan' => 'Data anggota berhasil diperbarui.'];
    header("Location: list.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()];
    header("Location: edit.php?id=" . urlencode($id));
    exit();
}