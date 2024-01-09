# Aplikasi-CRUD-Toko-HP

Tugas Besar Basis Data Terapan

List anggota kelompok: 
1. Damar Riyadi Syahputra (32602200052)
2. Ella Heriyawati (32602200059)
3. Franklyn Rama Fitrah Akbar (32602200067)
4. Gilang Setiawan (32602200068)
5. Ikharista Ayu Nusrotun A (32602200078)

Keterangan Project:
Aplikasi Web berbasis PHP yang terhubung dengan mySQL
didalamnya terdapat mekanisme penambahan data, pengeditan data, lihat data, dan hapus data
selain itu terdapat Stored Procedure, Stored Function, View, dan Trigger
- Stored Procedure: tambah_produk, tambah_pelanggan, dan tambah_transaksi: menggantikan query tambah data (INSERT) menjadi pemanggilan Stored Procedure
- Stored Function: jumlah_produk: menghitung total produk yang ada
- View: jumlah_pembelian: menghitung jumlah pembelian pelanggan yang ada di tabel transaksi
- Trigger: hapus_transaksi: saat menghapus pelanggan di tabel pelanggan otomatis pelanggan yang ada di tabel transaksi akan ikut terhapus melalui foreign key id_pelanggan


Cara Menggunakan Aplikasi:
1. tambahkan path php ke dalam environment variables > system variables > path
   ![Screenshot 2024-01-09 111355](https://github.com/Dzoee123/Aplikasi-CRUD-Toko-HP/assets/137170947/9e4540bd-8184-4aa1-9b33-fc9a8dc95618)
   
2. import file sql ke dalam database   
   ![Screenshot 2024-01-09 104305](https://github.com/Dzoee123/Aplikasi-CRUD-Toko-HP/assets/137170947/d68296f8-e942-43f6-bf88-473b9059a36c)

3. pindah folder toko_hp yang di dalam nya terdapat folder admin/index.php dan folder config/koneksi.php
   ![Screenshot 2024-01-09 111436](https://github.com/Dzoee123/Aplikasi-CRUD-Toko-HP/assets/137170947/f398b894-d946-4bad-8d95-25cf72968d07)
   
4. jangan lupa start apache dan mysql pada xampp
   ![Screenshot 2024-01-09 111523](https://github.com/Dzoee123/Aplikasi-CRUD-Toko-HP/assets/137170947/5c849844-addb-4411-9bb9-f1d9e8314e3e)
   
5. kemudian buka browser dan masuk ke localhost/toko_hp
   ![Screenshot 2024-01-09 111628](https://github.com/Dzoee123/Aplikasi-CRUD-Toko-HP/assets/137170947/34672ab1-d39e-43ae-8a37-a43b1809531f)
   
6. untuk penjelasan koding dan demo aplikasi bisa dibuka link youtube berikut
   link


