<?php
session_start();
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute([':id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Data buku tidak ditemukan.'];
    header("Location: list.php");
    exit();
}
?>

<section>
    <h2>Edit Buku</h2>

    <!-- Latihan 1: Konfirmasi sebelum submit -->
    <form id="form-edit" method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data ini?');">
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">

        <p>
            <label for="judul">Judul Buku</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
        </p>

        <p>
            <label for="pengarang">Pengarang</label><br>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required>
        </p>

        <p>
            <label for="tahun">Tahun Terbit</label><br>
            <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($buku['tahun']); ?>" required>
        </p>

        <p>
            <label for="stok">Stok</label><br>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($buku['stok']); ?>" required>
        </p>

        <button type="submit">Simpan Perubahan</button>
        <button type="button" onclick="location.href='list.php'">Batal</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>