# Sipeka-MBG

**Sipeka-MBG** (Sistem Pengecekan Kesegaran Bahan untuk MBG) adalah aplikasi pengelolaan bahan makanan untuk Program Makan Bergizi Gratis. Aplikasi ini membantu SPPG mengelola inventaris bahan makanan, memantau kualitas bahan, dan menampilkan hasil analisis kesegaran dalam satu platform berbasis Laravel.

## 👥 Anggota Kelompok

1. 245150700111048 - Keihan Radja Vasya
2. 245150700111017 - Muhammad Iqbal Dhyty Pratama
3. 245150701111011 - Dionisius Seraf Saputra
4. 245150701111017 - Ezekiel Aaron Marmora

## Latar Belakang

**Program Makan Bergizi Gratis (MBG)** merupakan salah satu pilar strategis pemerintah dalam meningkatkan kualitas sumber daya manusia, menekan angka stunting, serta memastikan pemenuhan gizi seimbang bagi generasi muda sejak dini. Keberhasilan program berskala nasional ini sangat bergantung pada rantai pasok dan operasional Satuan Pelayanan Program Gizi (SPPG) sebagai garda terdepan penyedia makanan.

Dalam implementasinya, mutu dan keamanan pangan dalam MBG masih cukup memprihatinkan. Banyak bahan makanan yang tidak segar atau terkontaminasi tidak hanya menurunkan nilai gizi, tetapi juga membawa risiko fatal bagi kesehatan penerima manfaat. Oleh karena itu, SIPEKA diharapkan pengawasan kualitas bahan baku di tingkat SPPG mutlak diperlukan sebelum proses pengolahan dilakukan.

## 🎯 Fitur-fitur

### Fitur Wajib

1. **Freshness Check Makanan MBG**: Mengecek kesegaran bahan makanan berdasarkan foto yang diinput oleh pengguna.
2. **Storage Input**: Memasukkan data bahan makanan baru ke dalam sistem.
3. **Storage Edit/Update**: Mengubah atau memperbarui data bahan makanan yang sudah ada.
4. **Storage View**: Melihat daftar dan detail data setiap bahan makanan yang sudah diinput.
5. **Register/Login**: Akses masuk ke sistem untuk pengguna.

### Fitur Opsional

1. **Alerting Kadaluarsa Bahan Makanan**: Peringatan otomatis untuk bahan yang akan segera kedaluwarsa.
2. **Filtering Kategori Bahan Makanan / Durasi Kadaluarsa**: Pemfilteran data untuk memudahkan pencarian bahan.
3. **Kode Verifikasi SPPG**: Fitur keamanan tambahan untuk verifikasi akses.

## 👤 _Role_

| Role  | Hak Akses                                                                 |
| :---- | :------------------------------------------------------------------------ |
| User  | Hak akses CRUD terhadap bahan makanan yang akan dimasukan ke SPPG terkait |
| Admin | Hak akses CRUD penuh terhadap sistem                                      |

## 🔄 Alur Sistem

**Proses Pengelolaan dan Pengecekan Kesegaran:**

1. **Akses Utama**: User mengakses halaman utama aplikasi yang menampilkan _storage view_ dari SPPG.
2. **Aksi User**: User memilih tombol input atau edit data untuk memperbarui inventaris.
3. **Input Data**: User menginput data detail bahan makanan beserta fotonya.
4. **Proses ML**: Sistem mengirimkan data foto bahan makanan tersebut ke model _Machine Learning_.
5. **Output Model**: Model memberikan hasil analisis dalam format JSON ke API.
6. **Hasil Akhir**: API mengembalikan data JSON tersebut ke halaman hasil untuk ditampilkan kepada user.

## 🗂️ Desain _Database_

1. **Tabel User**
    - `Id_user` (Auto increment): PK
    - `Nama` (Varchar)
    - `Email` (Varchar)
    - `Password` (Varchar)
    - `ID_Kitchen` (Varchar): FK
    - `avatar` (Varchar)

2. **Tabel Ingredients**
    - `ID_Ingredient` (Auto increment): PK
    - `Nama` (Varchar)
    - `TanggalDatang` (Date)
    - `Kadaluarsa` (Date)
    - `Kuantitas` (Integer)
    - `Satuan` (Varchar)
    - `Foto` (Varchar)
    - `Status_Kesegaran` (Varchar)

3. **Tabel Kichens**

## 🧩 Ringkasan Proyek

Sipeka-MBG dibangun dengan Laravel, Tailwind CSS, dan Vite. Proyek dijalankan secara containerized menggunakan Docker Compose untuk memastikan lingkungan pengembangan konsisten.

Aplikasi ini menyediakan:

- Autentikasi pengguna (registrasi, login, profil).
- Manajemen bahan makanan (tambah, edit, lihat, hapus).
- Analisis kesegaran bahan makanan.
- Peran `User` dan `Admin` untuk kontrol akses.

## 🚀 Setup Proyek

### Prasyarat

- Docker
- Docker Compose v2
- Salin file `.env.example` ke `.env`

### 1. Salin file environment

```bash
cp .env.example .env
```

### 2. Konfigurasi `.env`

Gunakan konfigurasi berikut untuk lingkungan Docker:

```env
APP_NAME=Sipeka-MBG
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=project_pawl
DB_USERNAME=root
DB_PASSWORD=Harvey.33

MYSQL_ROOT_PASSWORD=Harvey.33
```

> Catatan: `DB_HOST=db` digunakan untuk koneksi antar container melalui Docker Compose.

### 3. Jalankan Docker Compose

```bash
docker compose up --build
```

Setelah service aktif:

- Aplikasi tersedia di `http://localhost`
- Vite dev server tersedia di `http://localhost:5173`

### 4. Inisialisasi Laravel

Jalankan perintah berikut setelah container berjalan:

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

## 🐳 Konfigurasi Docker

Proyek ini menyediakan dua konfigurasi Docker: **development** untuk pengembangan lokal dengan hot reload, dan **production** untuk deployment.

### Prasyarat

- Docker
- Docker Compose v2
- Salin file `.env.example` ke `.env`

### Development

Mode development menggunakan volume mount sehingga perubahan kode langsung terlihat tanpa rebuild. Vite HMR aktif di port `5173`.

Jika Anda berada di Windows PowerShell:

```powershell
copy .env.example .env
```

Atau pada Bash / Git Bash:

```bash
cp .env.example .env
```

Setelah `.env` disiapkan, jalankan:

```bash
docker compose up --build
```

Untuk menjalankan di background:

```bash
docker compose up -d --build
```

Service yang berjalan:

| Service | Keterangan                                           |
| :------ | :--------------------------------------------------- |
| `app`   | PHP-FPM dengan kode mount dari host                  |
| `nginx` | Web server di port `80`                              |
| `db`    | MySQL 8.0, host port `3307` ke container port `3306` |
| `queue` | Laravel queue worker                                 |
| `vite`  | Vite dev server pada port `5173`                     |

> Catatan: Aplikasi menggunakan `DB_HOST=db` di `.env` untuk koneksi antar container. Jika perlu mengakses database langsung dari host, gunakan port `3307`.

### Production

File `docker-compose.prod.yml` menyiapkan deployment production dengan kode yang dibangun ke dalam image.

- `app`: Image production tanpa volume mount kode
- `nginx`: Menyajikan folder `public` dari image app
- `queue`: Worker production
- `db`: MySQL dengan volume persisten
- `vite`: Dinonaktifkan di production karena hanya diperlukan di dev

Untuk menjalankan production:

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d
```

Perbedaan utama dibanding mode development:

- Kode aplikasi **di-bake ke dalam image** (tidak ada volume mount)
- Aset frontend dikompilasi di dalam Docker image
- `APP_DEBUG=false`, `APP_ENV=production`
- Cache config, route, dan view sebaiknya diaktifkan pada build production
- Service `vite` tidak berjalan

## 💻 Perintah Berguna

```bash
# Melihat log semua service
docker compose logs -f

# Masuk ke shell container app
docker compose exec app bash

# Jalankan artisan command
docker compose exec app php artisan <perintah>

# Hentikan semua service
docker compose down

# Hentikan dan hapus volume database
docker compose down -v
```

## 📦 Frontend & Build

Jika ingin menjalankan Vite di container:

```bash
docker compose exec vite npm run dev -- --host
```

Untuk membangun aset frontend secara manual:

```bash
docker compose exec app npm install
docker compose exec app npm run build
```

## 📌 Catatan Penting

- Pastikan `.env` sudah diatur sesuai lingkungan Docker.
- Port MySQL host container adalah `3307`, tetapi aplikasi menggunakan `3306` di dalam container.
- Jika diperlukan konfigurasi API tambahan, tambahkan ke `.env` sesuai kebutuhan backend.
