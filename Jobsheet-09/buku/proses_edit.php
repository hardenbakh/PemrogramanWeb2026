<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit();
}

$id = $_POST['id'] ?? null;
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = (int) ($_POST['tahun'] ?? 0);
$stok = (int) ($_POST['stok'] ?? 0);

if (!$id || empty($judul) || empty($pengarang)) {
    $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Semua field wajib diisi.'];
    header("Location: edit.php?id=" . urlencode($id));
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE buku SET judul = :judul, pengarang = :pengarang, tahun = :tahun, stok = :stok WHERE id = :id");
    $stmt->execute([
        ':judul' => $judul,
        ':pengarang' => $pengarang,
        ':tahun' => $tahun,
        ':stok' => $stok,
        ':id' => $id
    ]);

    $_SESSION['flash'] = ['type' => 'sukses', 'pesan' => 'Data buku berhasil diperbarui.'];
    header("Location: list.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()];
    header("Location: edit.php?id=" . urlencode($id));
    exit();
}