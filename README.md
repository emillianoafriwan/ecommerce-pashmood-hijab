# Ecommerce Pashmood

## Ringkasan Project

Ecommerce Pashmood adalah aplikasi web berbasis Laravel untuk mengelola penjualan dan pre-order produk hijab pashmina. Project ini berfokus pada proses belanja sederhana: pembeli mencari produk, memilih variasi, memasukkan produk ke keranjang, melakukan checkout, mengunggah bukti pembayaran, lalu menunggu verifikasi dan pengiriman dari admin.

Tujuan utama project ini adalah membuat sistem e-commerce internal yang rapi, mudah digunakan, dan jelas alurnya untuk pembeli maupun admin.

## Tujuan Utama

- Menyediakan katalog produk hijab pashmina yang dapat dicari dan difilter berdasarkan kategori.
- Mendukung proses pre-order produk dengan variasi warna dan bahan.
- Memudahkan pembeli membuat pesanan, mengunggah bukti pembayaran, melihat riwayat pesanan, membatalkan pesanan sebelum diproses, dan mengonfirmasi barang diterima.
- Memudahkan admin mengelola kategori, produk, variasi, pembayaran, pengiriman, resi, dan laporan penjualan.
- Menjaga alur transaksi tetap terkontrol dari pre-order sampai pesanan selesai.

## Ruang Lingkup Fitur

### Fitur Pembeli

- Registrasi, login, dan pengelolaan profil.
- Melihat daftar produk.
- Mencari produk berdasarkan nama atau deskripsi.
- Memfilter produk berdasarkan kategori.
- Melihat detail produk dan variasi yang tersedia.
- Menambahkan produk ke keranjang.
- Checkout dengan alamat, nomor telepon, dan pilihan kurir.
- Mengunggah bukti pembayaran.
- Melihat detail dan riwayat pesanan.
- Membatalkan pesanan dengan alasan selama status masih memungkinkan.
- Mengonfirmasi pesanan diterima.
- Memberikan ulasan produk setelah pesanan selesai.

### Fitur Admin

- Dashboard ringkasan pendapatan, pesanan pending, pesanan selesai, dan jumlah produk.
- Manajemen kategori produk.
- Manajemen produk, gambar, harga, dan variasi warna.
- Melihat daftar dan detail pesanan.
- Memverifikasi atau menolak bukti pembayaran.
- Mengirim alasan penolakan pembayaran kepada pembeli.
- Membuat nomor resi otomatis.
- Mencetak label/resi pengiriman.
- Mengubah status pesanan menjadi dikirim.
- Mencetak laporan penjualan dari pesanan yang sudah menghasilkan pendapatan.

## Alur Status Pesanan

1. `pre_order` - pesanan dibuat oleh pembeli setelah checkout.
2. `waiting` - pembeli sudah mengunggah bukti pembayaran dan menunggu verifikasi admin.
3. `paid` - pembayaran disetujui oleh admin.
4. `shipped` - admin sudah membuat resi dan mengirim pesanan.
5. `completed` - pembeli mengonfirmasi barang sudah diterima.
6. `canceled` - pembeli membatalkan pesanan sebelum proses selesai.

Jika pembayaran ditolak, pesanan kembali ke status `pre_order`, bukti pembayaran dihapus, dan alasan penolakan disimpan.

## Batasan Agar Project Tidak Melenceng

- Project ini difokuskan pada e-commerce/pre-order produk hijab pashmina Pashmood, bukan marketplace multi-penjual.
- Sistem pembayaran saat ini berbasis unggah bukti transfer, bukan payment gateway otomatis.
- Pengiriman menggunakan pilihan kurir dan nomor resi internal, bukan integrasi API ekspedisi.
- Project ini menggunakan sistem pre-order, sehingga produk tidak bergantung pada stok barang ready stock.
- Laporan penjualan dihitung dari pesanan dengan status `paid`, `shipped`, dan `completed`.
- Admin tidak melakukan checkout; admin hanya mengelola produk, pesanan, pengiriman, dan laporan.
- Fitur baru sebaiknya mendukung alur utama: katalog, keranjang, pre-order, verifikasi pembayaran, pengiriman, penyelesaian pesanan, dan laporan.

## Teknologi

- Laravel
- Laravel Breeze untuk autentikasi
- Blade
- Tailwind CSS
- Alpine.js
- Vite
- MySQL atau database lain yang didukung Laravel

## Panduan Pengembangan

Saat menambah fitur, pastikan fitur tersebut menjawab salah satu kebutuhan berikut:

- Membantu pembeli menemukan dan membeli produk hijab pashmina Pashmood.
- Membantu admin mengelola produk, pesanan, pembayaran, atau pengiriman.
- Membuat status transaksi lebih jelas dan mudah dilacak.
- Meningkatkan keamanan, validasi, atau keandalan data transaksi.
- Memperbaiki tampilan tanpa mengubah tujuan utama aplikasi.

Hindari menambahkan fitur yang terlalu jauh dari kebutuhan e-commerce hijab pashmina, seperti forum umum, sistem multi-vendor kompleks, dompet digital internal, atau fitur sosial media, kecuali memang sudah menjadi kebutuhan resmi project.