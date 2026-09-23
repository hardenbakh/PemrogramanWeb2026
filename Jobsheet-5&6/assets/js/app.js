// ==============================================================================
// JOBSHEET 5 & 6: Interaktivitas DOM, Form Validation, Filter, & Event Delegation
// ==============================================================================

// [JOBSHEET 5] 1. Hamburger Menu (Responsive Navbar)
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    // Toggle class .nav-open saat tombol hamburger diklik
    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// [JOBSHEET 6] 2. Konfirmasi Hapus Baris Tabel dengan Event Delegation
// Alasan: Tombol .btn-hapus dibuat dinamis setelah fetch JSON selesai (tidak ada saat halaman pertama kali load).
// Maka event listener dipasang di root 'document', lalu mendeteksi klik pada .btn-hapus.
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        // Ambil nama/judul di kolom pertama sebagai konteks dialog
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        
        // Hapus elemen <tr> dari tampilan browser (front-end only)
        if (yakin && row) {
            row.remove();
        }
    });
}

// [JOBSHEET 5] 3. Filter / Pencarian Tabel Real-Time
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    // Trigger setiap kali user mengetik karakter (event 'keyup')
    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        
        // Cek apakah isi baris mengandung kata kunci pencarian
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// [JOBSHEET 5] 4. Helper Tampilkan & Hapus Pesan Error Validasi Form
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

// [JOBSHEET 5] 5. Validasi Form Client-Side pada Halaman Tambah
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Validasi field Judul / Nama (tidak boleh kosong)
        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        // Validasi field Pengarang (tidak boleh kosong)
        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }

        // Validasi Tahun Terbit (angka di antara 1900 - 2026)
        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        // Validasi Stok (angka tidak boleh negatif)
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        // Jika salah satu aturan tidak terpenuhi, batalkan pengiriman form
        if (!valid) {
            e.preventDefault();
        }
    });
}

// Inisialisasi seluruh fitur umum saat DOM siap
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});