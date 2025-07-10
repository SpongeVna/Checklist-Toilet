# 🚽 Aplikasi Checklist Toilet - UAS Sistem Terdistribusi

Aplikasi web sederhana untuk melakukan checklist kebersihan toilet, dikembangkan sebagai bagian dari tugas UAS Mata Kuliah **Sistem Terdistribusi**. Aplikasi ini memungkinkan petugas melakukan pencatatan kondisi toilet secara digital, dengan fitur login user/admin, manajemen lokasi, dan export laporan ke Excel.

---

## ✨ Fitur Utama

- ✅ Login sesuai peran (Admin & Pengguna)
- ✅ Checklist kelengkapan toilet (Sabun, Tisu, Air, Tidak Bau, Lantai Bersih)
- ✅ Tambah, edit, dan hapus lokasi toilet (Admin)
- ✅ Laporan checklist lengkap + export ke Excel (Admin)
- ✅ Manajemen akun pengguna (Admin)
- ✅ Mode gelap (dark mode toggle)
- ✅ Responsive design menggunakan Bootstrap 5

---

## 🛠️ Teknologi

- **Frontend**: HTML5, CSS3, [Bootstrap 5](https://getbootstrap.com)
- **Backend**: PHP 7+
- **Database**: MySQL (phpMyAdmin)
- **Export**: Spreadsheet (Excel via `xls`/CSV)
- **Deployment**: Lokal (`localhost`) via [XAMPP](https://www.apachefriends.org)

---

## 📂 Struktur Folder

checklist-toilet/
│
├── assets/
│ └── css-img/
│ └── style.css
│
├── includes/
│ └── db.php # Koneksi database
│ └── session.php # Cek login session
│
├── admin/
│ ├── index.php # Dashboard admin
│ ├── lokasi.php # Manajemen lokasi
│ ├── laporan.php # Laporan checklist
│ ├── edit_checklist.php
│ ├── users.php # Manajemen akun
│ ├── export_excel.php
│ ├── delete_checklist.php
│ ├── edit_user.php
│ ├── hapus_user.php
│ └── tambah_user.php
│
├── pengguna/
│ ├── index.php # Dashboard pengguna
│ └── checklist.php # Form checklist
│
├── login.php # Form login
├── logout.php # Logout
└── README.md # Ini dia

markdown
Salin
Edit

---

## 🔑 Akun Demo

| Role    | Username | Password |
|---------|----------|----------|
| Admin   | `admin1` | `123456` |
| Pengguna| `user1`  | `123456` |

> Username & password dapat diubah melalui halaman manajemen akun.

---

## ⚙️ Cara Menjalankan

1. **Install XAMPP** dan aktifkan `Apache` & `MySQL`
2. **Clone / Download** folder `checklist-toilet` ke direktori `htdocs`
3. **Import database**
   - Buka `phpMyAdmin`
   - Buat database: `checklist_toilet`
   - Import file SQL yang tersedia (`checklist_toilet.sql`)
4. **Jalankan di browser**:
   ```bash
   http://localhost/checklist-toilet/login.php
📌 Catatan Pengembangan
Sistem login menggunakan sesi PHP ($_SESSION)

Password masih dalam bentuk plain text (bisa di-upgrade dengan password_hash() untuk versi aman)

Responsive dan mobile-friendly

Tersedia toggle dark mode

👨‍💻 Developer
Kelompok 8 - TI.23.B2
Pengembang :   @i.ilyaasss
               @_ohnovi
               @maulidakn_
Pembimbing: Agung Nugroho, S.Kom., M.Kom.
Mata kuliah: Pemrograman Web 2
Universitas Pelita Bangsa – Fakultas Teknik - Prodi Informatika - Semester 4 

📄 Lisensi
© 2025 – Untuk keperluan akademik.
Boleh dimodifikasi untuk pengembangan lebih lanjut selama menyertakan kredit pembuat.