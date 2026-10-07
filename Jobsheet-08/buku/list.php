<?php
session_start();
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

// LOGIKA HAPUS DATA 
// tambahan agar data dapat dihapus

if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['flash'] = [
                    'type' => 'sukses',
                    'pesan' => 'Buku berhasil dihapus.'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'gagal',
                    'pesan' => 'Data buku tidak ditemukan.'
                ];
            }
        } catch (PDOException $e) {
            $_SESSION['flash'] = [
                'type' => 'gagal',
                'pesan' => 'Gagal menghapus buku: ' . $e->getMessage()
            ];
        }
    }
    
    // Redirect ke halaman yang sama untuk menghilangkan parameter URL hapus
    header("Location: list.php");
    exit();
}

// list php dari repository
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarBuku = $pdo->query("SELECT * FROM buku ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Daftar Buku</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <div class="search-box">
                <label for="search-input">Cari Judul Buku</label>
                <input type="text" id="search-input" placeholder="Ketik judul buku...">
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="5">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarBuku as $buku): ?>
                        <tr>
                            <td><?php echo $buku['judul']; ?></td>
                            <td><?php echo $buku['pengarang']; ?></td>
                            <td><?php echo $buku['tahun']; ?></td>
                            <td><?php echo $buku['stok']; ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>