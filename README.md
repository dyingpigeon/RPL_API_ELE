untuk menggunakan api ini anda diharuskan untuk membuat migrasi dahulu, kemudian seed database tsb
jalankan laravel di direktori projek dengan command "php artisan serve"
untuk migrasi tulis "php artisan migrate:fresh"
kemudian seed dengan "php artisan db:seed"

untuk mengakses api di web:
tulis "127.0.0.1:8000/api/vi/'data yang diinginkan'"
misal "127.0.0.1:8000/api/vi/mahasiswa"
jika ingin mencari menggunakan id "127.0.0.1:8000/api/vi/mahasiswa/'id'"
jika ingin mencari berdasarkan nama field bisa menggunakan "?nama='nama'"
contohnya "127.0.0.1:8000/api/vi/mahasiswa?nama=jes"