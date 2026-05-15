# Sipeka-MBG

**Sipeka-MBG** (Sistem Pengecekan Kesegaran Bahan untuk MBG) adalah platform yang digunakan oleh SPPG MBG untuk melakukan manajemen bahan makanan yang akan digunakan untuk program MBG. Sistem ini memungkinkan pengguna untuk memantau kualitas bahan baku secara digital melalui integrasi teknologi *Machine Learning*.

## 👥 Anggota kelompok
1. 245150700111048 - Keihan Radja Vasya
2. 245150700111017 - Muhammad Iqbal Dhyty Pratama
3. 245150701111011 - Dionisius Seraf Saputra
4. 245150701111017 - Ezekiel Aaron Marmora

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
| Role | Hak Akses |
| :--- | :--- |
| User | Hak akses penuh ke seluruh fitur interface aplikasi |

## 🔄 Alur Sistem

**Proses Pengelolaan dan Pengecekan Kesegaran:**
1. **Akses Utama**: User mengakses halaman utama aplikasi yang menampilkan *storage view* dari SPPG.
2. **Aksi User**: User memilih tombol input atau edit data untuk memperbarui inventaris.
3. **Input Data**: User menginput data detail bahan makanan beserta fotonya.
4. **Proses ML**: Sistem mengirimkan data foto bahan makanan tersebut ke model *Machine Learning*.
5. **Output Model**: Model memberikan hasil analisis dalam format JSON ke API.
6. **Hasil Akhir**: API mengembalikan data JSON tersebut ke halaman hasil untuk ditampilkan kepada user.

## 🗂️ Desain _Database_

1. **Tabel User**
   * `Id_user` (Auto increment): PK
   * `Nama` (Varchar)
   * `Email` (Varchar)
   * `Password` (Varchar)
   * `ID_SPPG` (Varchar): FK

2. **Tabel BahanMakanan**
   * `ID_Bahan` (Auto increment): PK
   * `Nama` (Varchar)
   * `TanggalMasuk` (Date)
   * `Kadaluarsa

## 🐳 Menjalankan dengan Docker

Proyek ini menyediakan dua konfigurasi Docker: **development** untuk pengembangan lokal dengan hot reload, dan **production** untuk deployment.

### Prasyarat

- [Docker](https://docs.docker.com/get-docker/) dan Docker Compose v2 terinstal
- File `.env` sudah dikonfigurasi (salin dari `.env.example`)

### Development

Mode development melakukan *volume mount* kode secara langsung ke container sehingga perubahan file langsung terlihat tanpa rebuild. Vite HMR aktif di port `5173`.

```bash
# 1. Salin dan isi environment
cp .env.example .env
# Edit .env — pastikan mengisi variabel berikut:
#   ML_API_URL=http://alamat-api-ml-anda
#   DB_DATABASE=sipeka
#   DB_USERNAME=sipeka
#   DB_PASSWORD=secret

# 2. Jalankan semua service
docker compose up --build

# Aplikasi berjalan di http://localhost
# Vite HMR berjalan di http://localhost:5173
```

Service yang berjalan:
| Service | Keterangan |
| :--- | :--- |
| `app` | PHP-FPM 8.3 |
| `nginx` | Web server, port 80 |
| `db` | MySQL 8.0 |
| `queue` | Laravel queue worker |
| `vite` | Vite dev server + HMR, port 5173 |

### Production

Mode production melakukan build aset frontend di dalam Docker (tidak perlu `npm run build` lokal), menonaktifkan debug, dan mengaktifkan cache konfigurasi/route/view.

```bash
# Jalankan dengan menggabungkan kedua compose file
docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d
```

Perbedaan utama dibanding mode development:
- Kode aplikasi **di-bake ke dalam image** (tidak ada volume mount)
- Aset frontend dikompilasi oleh Node di dalam Docker (multi-stage build)
- `APP_DEBUG=false`, `APP_ENV=production`
- Cache config, route, dan view diaktifkan otomatis saat build
- Service `vite` tidak berjalan

### Perintah berguna

```bash
# Melihat log semua service
docker compose logs -f

# Masuk ke shell container app
docker compose exec app bash

# Jalankan artisan command
docker compose exec app php artisan <perintah>

# Menghentikan semua service
docker compose down

# Menghentikan dan menghapus volume database (reset data)
docker compose down -v
```
