# Catatan Kolaborasi Final Project

(Final project) dikerjakan secara bersama di satu laptop.
Commit utama menggunakan 1 akun, namun pengerjaan dilakukan berdua.

1. Deskripsi Umum Final Project

Final Project ini merupakan ujian praktikum mata kuliah Pemrograman Web yang berfokus pada pembuatan aplikasi E-Commerce berbasis Laravel 12.
Repository awal sudah menyediakan Starter Kit Laravel Breeze serta seluruh file migration database. Tugas utama kami adalah membangun aplikasi e-commerce yang lengkap mulai dari autentikasi, CRUD, sistem pembayaran, hingga pengelolaan role pengguna.

Aplikasi akhir harus menerapkan:
	•	Struktur MVC Laravel
	•	Role Based Access Control (RBAC)
	•	Sistem keuangan internal (wallet dan virtual account)
	•	Halaman pembayaran terpusat
	•	Fitur CRUD untuk Customer, Seller, dan Admin

2. Struktur Database

Repository awal menyediakan tabel inti seperti users, stores, products, product_categories, product_images, transactions, dan transaction_details.
Selain itu, kami juga membuat tabel tambahan seperti:
	•	user_balances (menyimpan saldo wallet user)
	•	store_balances (saldo toko)
	•	virtual_accounts (kode VA untuk pembayaran)
	•	balance_histories (riwayat saldo)

3. Setup Teknis Proyek

Langkah menjalankan project:
	1.	Menjalankan composer install.
	2.	Menyalin .env.example menjadi .env dan mengatur konfigurasi database.
	3.	Menjalankan php artisan key:generate.
	4.	Menerapkan migration dengan php artisan migrate.
	5.	Membuat seeder untuk Admin, Member, Store, kategori, dan produk.
	6.	Menjalankan server dengan php artisan serve.
	7.	Instalasi dan build front-end dengan npm install, npm run build, dan npm run dev.

4. Fitur Wajib yang Diimplementasikan

A. Customer Side
	•	Homepage: menampilkan semua produk dan filter kategori.
	•	Halaman Produk: menampilkan detail produk, gambar, store, dan review.
	•	Checkout: memasukkan alamat, memilih shipping, memilih metode pembayaran (Wallet atau VA), dan membuat transaksi.
	•	Riwayat Transaksi: menampilkan daftar transaksi sebelumnya.
	•	Topup Wallet: menghasilkan nomor VA untuk pengisian saldo.

B. Seller Dashboard

Dapat diakses hanya oleh member yang memiliki store.
	•	Pendaftaran Store
	•	Manajemen Profil Store
	•	CRUD Kategori
	•	CRUD Produk dan Gambar Produk
	•	Melihat pesanan masuk dan update status transaksi
	•	Melihat saldo toko dan riwayat saldo
	•	Pengajuan penarikan dana

C. Admin Panel

Hanya dapat diakses admin.
	•	Verifikasi atau penolakan pendaftaran toko
	•	Manajemen user dan store


5. Implementasi Tantangan Utama

1. Role Based Access Control (RBAC)

Setiap role memiliki hak akses berbeda:
	•	Admin → akses penuh halaman admin
	•	Seller → dashboard toko
	•	Customer → halaman transaksi dan pembelian

2. Sistem Pembayaran & Wallet

Terdapat dua sistem pembayaran:
	1.	Wallet: user topup terlebih dahulu melalui VA, lalu saldo dipotong saat checkout.
	2.	Transfer VA: sistem membuat VA unik untuk transaksi pembelian.

3. Halaman Pembayaran Terpusat

Digunakan untuk:
	•	Memasukkan kode VA
	•	Menampilkan detail pembayaran
	•	Melakukan simulasi transfer
	•	Memproses topup atau pembayaran transaksi
