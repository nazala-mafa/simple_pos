# Aplikasi POS (point of sale) / Aplikasi Kasir

## Instalasi untuk penggunaan offline
1. Install composer
2. Install xampp
3. Unduh aplikasi dan extract 
4. Ubah file `env` menjadi `.env`
5. Sesuaikan file `.env`
6. Buat database dengan nama `simple_app`
7. Buka cmd di folder tempat aplikasi
8. Jalankan perintah
 - `composer update`
 - `php spark migrate --all`
 - `php spark db:seed DataSeeder`

## Instalasi untuk penggunaan online
1. Clone repository
2. Ubah file `env` menjadi `.env`
3. Sesuaikan `.env`
4. Buat database
5. Jalankan Perintah
 - `composer update`
 - `php spark migrate --all`
 - `php spark db:seed DataSeeder`
