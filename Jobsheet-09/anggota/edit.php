<?php
session_start();
$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute([':id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    $_SESSION['flash'] = ['type' => 'gagal', 'pesan' => 'Data anggota tidak ditemukan.'];
    header("Location: list.php");
    exit();
}
?>

<section>
    <h2>Edit Anggota</h2>

    <form id="form-edit" method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data anggota ini?');">
        <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">

        <p>
            <label for="no_anggota">No. Anggota / NIM</label><br>
            <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($anggota['no_anggota'] ?? $anggota['id']); ?>" required>
        </p>

        <p>
            <label for="nama">Nama Anggota</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama'] ?? ''); ?>" required>
        </p>

        <p>
            <label for="alamat">Alamat</label><br>
            <textarea id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($anggota['alamat'] ?? ''); ?></textarea>
        </p>

        <p>
            <label for="no_hp">No. HP / Telepon</label><br>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($anggota['no_hp'] ?? $anggota['telepon'] ?? ''); ?>" required>
        </p>

        <button type="submit">Simpan Perubahan</button>
        <button type="button" onclick="location.href='list.php'">Batal</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>