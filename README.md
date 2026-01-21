# 📘 Aplikasi Logbook Insiden

Aplikasi **Logbook Insiden** adalah aplikasi berbasis web yang dibuat untuk mencatat dan mengelola data insiden harian berdasarkan form yang sebelumnya menggunakan **Excel**, kemudian dikonversi menjadi **form aplikasi** dan disimpan ke dalam **database** menggunakan konsep **CRUD (Create, Read, Update, Delete)**.

Aplikasi ini dikembangkan menggunakan **Laravel** sebagai backend dan **Tailwind CSS** untuk tampilan antarmuka.

---

## 🎯 Tujuan Aplikasi

- Mengubah pencatatan insiden manual (Excel) menjadi sistem digital
- Memudahkan pencatatan, penyimpanan, dan pengelolaan data insiden
- Menyediakan tabel data insiden yang dapat diolah (CRUD)
- Menjadi media pembelajaran penerapan Laravel dalam proyek PKL

---

## 🛠️ Teknologi yang Digunakan

- **Laravel**
- **PHP**
- **MySQL**
- **Tailwind CSS**
- **Blade Template**
- **Alpine.js (opsional)**

---

## 📂 Fitur Aplikasi

### ✅ Manajemen Data Insiden
- Tambah data insiden
- Lihat daftar data insiden
- Edit data insiden
- Hapus data insiden

### ✅ Form Input Insiden
Form insiden dibuat berdasarkan data pada file Excel mentor, meliputi:
- Pelapor
- Metode pelaporan
- Waktu mulai
- Waktu selesai
- Downtime (otomatis dihitung)
- Nomor ticket
- Keterangan tambahan

### ✅ Tabel Data
Data yang telah diinput akan ditampilkan dalam tabel aplikasi dan dapat dikelola menggunakan fitur CRUD.

---

## 🗂️ Struktur Database (Contoh)

Tabel utama yang digunakan:
- `insiden`

Field utama:
- `id`
- `pelapor`
- `metode`
- `waktu_mulai`
- `waktu_selesai`
- `downtime`
- `no_ticket`
- `keterangan`
- `created_at`
- `updated_at`

> Struktur ini dapat dikembangkan sesuai kebutuhan (misalnya penambahan data KI atau detail insiden).

---

