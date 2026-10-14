<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit();
}

$id = $_POST['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $_SESSION['flash'] = ['type' => 'sukses', 'pesan' => 'Data anggota berhasil dihapus.'];
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Gagal menghapus anggota: ' . $e->getMessage()];
    }
}

header("Location: list.php");
exit();