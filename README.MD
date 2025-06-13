# SIMKIP - Sistem Informasi Manajemen KIP Kuliah Merdeka

Sistem ini dibuat untuk membantu pengelolaan proses pengajuan, penetapan, dan pencairan dana KIP Kuliah Merdeka di lingkungan LLDIKTI Wilayah II. Aplikasi ini berbasis web dan dibangun menggunakan framework **Laravel**.

## 🚀 Fitur Utama

- ✍️ Pengajuan mahasiswa baru dan mahasiswa ongoing oleh Operator PT
- ✅ Validasi dan penetapan oleh Operator LLDIKTI
- 📁 Upload & permintaan dokumen pendukung
- 💸 Pengajuan pencairan dana dan monitoring status
- 📊 Dashboard rekap data pengajuan, pencairan, dan status akhir

## ⚙️ Teknologi

- PHP 8.2.12
- Laravel 11.18.1
- MySQL
- HTML/CSS/JavaScript (Blade Template)
- Admin template: [Stisla](https://getstisla.com)

## 📥 Cara Clone & Menjalankan di Lokal

1. Clone the repository:
    ```bash
    git clone
    ```

2. Navigate into the project directory:
    ```bash
    cd laravel11-stisla
    ```

3. Install PHP dependencies:
    ```bash
    composer install
    ```

4. Install JavaScript dependencies:
    ```bash
    npm install && npm run dev
    ```

5. Copy the `.env.example` file and rename it to `.env`:
    ```bash
    cp .env.example .env
    ```

6. Generate application key:
    ```bash
    php artisan key:generate
    ```

7. Run database migrations:
    ```bash
    php artisan migrate
    ```

8. Start the development server:
    ```bash
    php artisan serve
    ```

##🙋‍♂️ Developer
- GitHub: @sukasukajija
- Email: sukasukajija@example.com
