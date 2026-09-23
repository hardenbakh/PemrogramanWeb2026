// ==============================================================================
// JOBSHEET 6: Fetch API, JSON, & Asynchronous JavaScript (Daftar Anggota)
// ==============================================================================

async function muatDaftarAnggota() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    // 1. Tampilkan indikator "Memuat data..." sebelum request dimulai
    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // 2. Simulasi delay jaringan (600ms) agar efek loading terlihat jelas
        await new Promise((resolve) => setTimeout(resolve, 600));

        // 3. Mengambil data dari file JSON secara asinkron via Fetch API
        const res = await fetch("../data/anggota.json");
        
        // 4. Validasi respon HTTP (status 200 OK)
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        // 5. Parse body JSON menjadi array of objects JavaScript
        const daftarAnggota = await res.json();

        // 6. Looping data JSON dan merender elemen <tr> ke dalam <tbody>
        daftarAnggota.forEach(function (anggota) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + anggota.no_anggota + "</td>" +
                "<td>" + anggota.nama + "</td>" +
                "<td>" + anggota.alamat + "</td>" +
                "<td>" + anggota.no_hp + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\">Detail</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        // 7. Penanganan error: tampilkan pesan kesalahan langsung di dalam tabel
        tbody.innerHTML =
            "<tr><td colspan=\"5\" style=\"text-align:center; color:red;\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        // 8. Sembunyikan kembali loading indicator setelah fetch selesai (baik sukses maupun gagal)
        loading.style.display = "none";
    }
}

// 9. Jalankan fungsi saat seluruh struktur DOM HTML selesai dimuat
document.addEventListener("DOMContentLoaded", muatDaftarAnggota);