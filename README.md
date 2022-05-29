# Aplikasi POS (point of sale) / Aplikasi Kasir

## Instalasi untuk penggunaan offline
1. Install composer
2. Install xampp
3. Unduh aplikasi dan extract 
4. Ubah file `env` menjadi `.env`
5. Buat database dengan nama `simple_app`
6. Buka cmd di folder tempat aplikasi
7. Jalankan perintah
 - `composer update`
 - `php spark migrate --all`
 - `php spark db:seed DataSeeder`

## Instalasi untuk penggunaan online
- Clone repository
- Ubah file `env` menjadi `.env`
- Buat database
- Jalankan `composer update`
- Jalankan `php spark migrate --all`
- Jalankan `php spark db:seed DataSeeder`
