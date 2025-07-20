# E-Prescription

Sistem resep elektronik berbasis Laravel yang memudahkan pencatatan, pencetakan, dan pengelolaan resep pasien secara digital.

## 📋 Persyaratan

Pastikan sistem Anda sudah terinstal dengan software berikut:

- PHP >= 8.1
- Composer
- Node.js >= 16
- NPM
- MySQL

## ⚙️ Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi secara lokal:

### 1. Clone Repository

```bash
git clone https://github.com/galihnrkhsn/e-prescription.git
cd e-prescription
```

### 2. Install Dependency Backend (PHP)

```bash
composer install
```

### 3. Install Dependency Frontend (Node.js)

```bash
npm install
```

### 4. Salin File `.env` dan Generate Key

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Install DomPDF

Untuk fitur cetak PDF:

```bash
composer require barryvdh/laravel-dompdf
```

### 6. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_DATABASE=e-prescription
DB_USERNAME=root
DB_PASSWORD=
```

> **Note:** Pastikan database `e-prescription` sudah dibuat di MySQL Anda.

### 7. Migrasi dan Seeder

Jalankan perintah berikut untuk membuat tabel dan data awal:

```bash
php artisan migrate --seed
```

### 8. Build Frontend dan Jalankan Server

```bash
npm run dev
php artisan serve
```

Aplikasi akan berjalan di: [http://localhost:8000](http://localhost:8000)

---

## 📄 Lisensi

Proyek ini menggunakan lisensi open-source [MIT](https://opensource.org/licenses/MIT).

## 👨‍💻 Pengembang

Galih Nur Ikhsan  
📧 galihnrkhsn@gmail.com  
🔗 [GitHub](https://github.com/galihnrkhsn)

---
