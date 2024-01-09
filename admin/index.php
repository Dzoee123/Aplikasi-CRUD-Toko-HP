<?php
include '../config/koneksi.php';

//inisialisasi variabel
$pilihan = '';
$nama_produk = '';
$harga = '';
$nama_pelanggan = '';
$asal = '';
$idPelanggan = '';
$totalPembelian = '';

//Melihat tabel berdasarkan opsi tabel pilihan
if (isset($_POST['pilihan'])) {
    $pilihan = $_POST['pilihan'];
    $sql = "SELECT * FROM $pilihan";
    if ($pilihan === 'jumlah_produk') {
        $sql = "SELECT jumlah_produk() AS Jumlah_Produk";
    }
    $result = $koneksi->query($sql);
}

//Mengambil dari input form tambah data
if (isset($_POST['tambah_data'])) {
    $pilihan = $_POST['pilihan'];
    $nama_produk = isset($_POST["nama_produk"]) ? $_POST["nama_produk"] : '';
    $harga = isset($_POST["harga"]) ? $_POST["harga"] : '';
    $nama_pelanggan = isset($_POST["nama_pelanggan"]) ? $_POST["nama_pelanggan"] : '';
    $asal = isset($_POST["asal"]) ? $_POST["asal"] : '';
    $idPelanggan = isset($_POST["id_pelanggan"]) ? $_POST["id_pelanggan"] : '';
    $totalPembelian = isset($_POST["total_pembelian"]) ? $_POST["total_pembelian"] : '';

    // Disini menggunakan Stored Procedure untuk menggantikan query tambah data
    switch ($pilihan) {
        case 'produk':
            $addquery = "CALL tambah_produk('$nama_produk', $harga)";
            break;
        case 'pelanggan':
            $addquery = "CALL tambah_pelanggan('$nama_pelanggan', '$asal')";
            break;
        case 'transaksi':
            $addquery = "CALL tambah_transaksi($idPelanggan, $totalPembelian)";
            break;
        default:
            echo "Pilih tabel terlebih dahulu.";
            exit();
    }
    if ($koneksi->query($addquery) === TRUE) {
        echo "<script>alert('Data berhasil ditambah');</script>";
    } else {
        echo "Error: " . $addquery . "<br>" . $koneksi->error;
    }
    $koneksi->close();
}

//Mengambil nilai tabel dan id untuk query hapus data
if (isset($_GET['id']) && isset($_GET['tabel'])) {
    $idToDelete = $_GET['id'];
    $tabel = $_GET['tabel'];

    $deleteQuery = "DELETE FROM $tabel WHERE id_$tabel = $idToDelete";

    if ($koneksi->query($deleteQuery) === TRUE) {
        echo "<script>alert('Data berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Error: " . $koneksi->error . "');</script>";
    }
}

//Penanganan untuk edit/update data
if (isset($_POST['ubah_data_' . $pilihan])) {
    $pilihan = $_POST['pilihan'];

    switch ($pilihan) {
        case 'produk':
            $updateQuery = "UPDATE $pilihan SET nama_produk = '$_POST[nama_produk]', harga = $_POST[harga] WHERE id_produk = $_POST[id_produk]";
            break;
        case 'pelanggan':
            $updateQuery = "UPDATE $pilihan SET nama_pelanggan = '$_POST[nama_pelanggan]', asal= '$_POST[asal]' WHERE id_pelanggan = $_POST[id_pelanggan]";
            break;
        case 'transaksi':
            $updateQuery = "UPDATE $pilihan SET id_pelanggan = $_POST[id_pelanggan], total_pembelian = $_POST[total_pembelian] WHERE id_transaksi = $_POST[id_transaksi]";
            break;
        default:
            break;
    }

    if ($koneksi->query($updateQuery) === TRUE) {
        echo "<script>alert('Data berhasil diubah');</script>";
    } else {
        echo "<script>alert('Error: " . $koneksi->error . "');</script>";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <h1 class="text-center">Selamat Datang Di Aplikasi CRUD</h1>
        <h1 class="text-center">Toko HP</h1>
        <h4>Pilih Tabel:</h4>
        <form action="index.php" method="post">
            <div class="form-group">
                <select class="form-control" id="pilihan" name="pilihan" required onchange="this.form.submit()">
                    <option value="" disabled selected>Pilih Tabel</option>
                    <option value="produk">Tabel Produk</option>
                    <option value="pelanggan">Tabel Pelanggan</option>
                    <option value="transaksi">Tabel Transaksi</option>
                    <option value="jumlah_pembelian">View Jumlah Pembelian</option>
                    <option value="jumlah_produk">Function Jumlah Produk</option>
                </select>
            </div>
        </form>

        <?php
        // Menyesuaikan judul tabel berdasarkan opsi pilihan
        if ($pilihan == "produk" || $pilihan == "pelanggan" || $pilihan == "transaksi") {
            echo "<tr>
                <td colspan='4'>
                    <h2>Tabel $pilihan</h2>
                </td>
            </tr>";
        } elseif ($pilihan == "jumlah_pembelian") {
            echo "<tr>
                <td colspan='4'>
                    <h2>View $pilihan</h2>
                </td>
            </tr>";
        } elseif ($pilihan == "jumlah_produk") {
            echo "<tr>
                <td colspan='4'>
                    <h2>Function $pilihan</h2>
                </td>
            </tr>";
        } else {
            echo "<tr>
                <td colspan='4'>
                    <h2>Pilih Tabel Terlebih Dahulu</h2>
                </td>
            </tr>";
        }
        ?>
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-secondary">
                <tr>
                    <?php
                    // Menyesuaikan header tabel berdasarkan tabel yang dipilih
                    switch ($pilihan) {
                        case "produk":
                            echo "<th>ID Produk</th><th>Nama Produk</th><th>Harga</th><th>Aksi</th>";
                            break;
                        case "pelanggan":
                            echo "<th>ID Pelanggan</th><th>Nama Pelanggan</th><th>Asal</th><th>Aksi</th>";
                            break;
                        case "transaksi":
                            echo "<th>ID Transaksi</th><th>ID Pelanggan</th><th>Total Pembelian</th><th>Aksi</th>";
                            break;
                        case "jumlah_pembelian":
                            echo "<th>ID Pelanggan</th><th>Nama Pelanggan</th><th>Jumlah Pembelian</th>";
                            break;
                        case "jumlah_produk":
                            echo "<th>Jumlah Produk</th>";
                            break;
                        default:
                            echo "<th>ID</th><th>Nama</th><th>Asal</th><th>Aksi</th>";
                    }
                    ?>
                </tr>
            </thead>
            <!-- isi tabel berdasarkan tabel yang dipilih -->
            <tbody>
                <?php
                if (isset($result) && $result !== null) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            switch ($pilihan) {
                                case "produk":
                                    echo "<tr><td>" . $row["id_produk"] . "</td>
                                        <td>" . $row["nama_produk"] . "</td>
                                        <td>" . $row["harga"] . "</td>
                                        <td>
                                            <a href='#' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalubahdataproduk$row[id_produk]'>Edit</a>
                                            <a href='index.php?id=" . $row["id_produk"] . "&tabel=" . $pilihan . "' class='btn btn-danger'>Hapus</a>
                                        </td></tr>


                                        <!-- Modal ubah data untuk tabel produk -->

                                        <form action='index.php' method='post'>
                                        <input type='hidden' name='pilihan' value='$pilihan'>
                                            <div class='modal fade' id='modalubahdataproduk$row[id_produk]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog modal-dialog-centered'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Ubah Data</h1>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <div class='form-section' id='produkForm'>
                                                                <div class='form-group'>
                                                                    <label for='nama_produk'>Nama Produk :</label>
                                                                    <input type='text' class='form-control' id='nama_produk' name='nama_produk' value='$row[nama_produk]'>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='harga'>Harga :</label>
                                                                    <input type='text' class='form-control' id='harga' name='harga' value='$row[harga]'>
                                                                </div>
                                                                <input type='hidden' name='id_produk' value='$row[id_produk]'>
                                                            </div>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='submit' class='btn btn-success' name='ubah_data_$pilihan'>Simpan Data</button>
                                                            <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        ";
                                    break;
                                case "pelanggan":
                                    echo "<tr><td>" . $row["id_pelanggan"] . "</td>
                                        <td>" . $row["nama_pelanggan"] . "</td>
                                        <td>" . $row["asal"] . "</td>
                                        <td>
                                            <a href='#' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalubahdatapelanggan$row[id_pelanggan]'>Edit</a>
                                            <a href='index.php?id=" . $row["id_pelanggan"] . "&tabel=" . $pilihan . "' class='btn btn-danger'>Hapus</a>
                                        </td></tr>


                                        <!-- Modal ubah data untuk tabel pelanggan -->
                                        
                                        <form action='index.php' method='post'>
                                        <input type='hidden' name='pilihan' value='$pilihan'>
                                            <div class='modal fade' id='modalubahdatapelanggan$row[id_pelanggan]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog modal-dialog-centered'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Ubah Data</h1>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <div class='form-section' id='pelangganForm'>
                                                                <div class='form-group'>
                                                                    <label for='nama_pelanggan'>Nama Pelanggan :</label>
                                                                    <input type='text' class='form-control' id='nama_pelanggan' name='nama_pelanggan' value='$row[nama_pelanggan]'>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='asal'>asal :</label>
                                                                    <input type='text' class='form-control' id='asal' name='asal' value='$row[asal]'>
                                                                </div>
                                                                <input type='hidden' name='id_pelanggan' value='$row[id_pelanggan]'>
                                                            </div>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='submit' class='btn btn-success' name='ubah_data_$pilihan'>Simpan Data</button>
                                                            <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        ";
                                    break;
                                case "transaksi":
                                    echo "<tr><td>" . $row["id_transaksi"] . "</td>
                                        <td>" . $row["id_pelanggan"] . "</td>
                                        <td>" . $row["total_pembelian"] . "</td>
                                        <td>
                                            <a href='#' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalubahdatatransaksi$row[id_transaksi]'>Edit</a>
                                            <a href='index.php?id=" . $row["id_transaksi"] . "&tabel=" . $pilihan . "' class='btn btn-danger'>Hapus</a></td>
                                        </td></tr>


                                        <!-- Modal ubah data untuk tabel transaksi -->

                                        <form action='index.php' method='post'>
                                        <input type='hidden' name='pilihan' value='$pilihan'>
                                            <div class='modal fade' id='modalubahdatatransaksi$row[id_transaksi]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog modal-dialog-centered'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Ubah Data</h1>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <div class='form-section' id='transaksiForm'>
                                                                <div class='form-group'>
                                                                    <label for='id_pelanggan'>ID Pelanggan :</label>
                                                                    <input type='text' class='form-control' id='id_pelanggan' name='id_pelanggan' value='$row[id_pelanggan]'>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='total_pembelian'>Total Pembelian :</label>
                                                                    <input type='text' class='form-control' id='total_pembelian' name='total_pembelian' value='$row[total_pembelian]'>
                                                                </div>
                                                                <input type='hidden' name='id_transaksi' value='$row[id_transaksi]'>
                                                            </div>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='submit' class='btn btn-success' name='ubah_data_$pilihan'>Simpan Data</button>
                                                            <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        ";
                                    break;
                                case "jumlah_pembelian":
                                    echo "<tr><td>" . $row["id_pelanggan"] . "</td>
                                        <td>" . $row["nama_pelanggan"] . "</td>
                                        <td>" . $row["Jumlah_Pembelian"] . "</td></tr>";
                                    break;
                                case "jumlah_produk":
                                    echo "<tr><td>" . $row["Jumlah_Produk"] . "</td></tr>";
                                    break;
                                default:
                                    echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
        if ($pilihan !== "" && $pilihan !== "jumlah_pembelian" && $pilihan !== "jumlah_produk") {
            echo "<tr>
                <td colspan='4'>
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modaltambahdata'>Tambahkan Data</button>                    
                </td>
            </tr>";
        }
        ?>

        <!-- Modal tambah data -->
        <form action="index.php" method="post">
            <input type="hidden" name="pilihan" value="<?= $pilihan ?>">
            <div class="modal fade" id="modaltambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            switch ($pilihan) {
                                case "produk":
                                    echo '
                                    <div class="form-section" id="produkForm">
                                        <div class="form-group">
                                            <label for="nama_produk">Nama Produk :</label>
                                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Samsung">
                                        </div>
                                        <div class="form-group">
                                            <label for="harga">Harga :</label>
                                            <input type="text" class="form-control" id="harga" name="harga" placeholder="12345678.99">
                                        </div>
                                    </div>';
                                    break;
                                case "pelanggan":
                                    echo '
                                    <div class="form-section" id="pelangganForm">
                                        <div class="form-group">
                                            <label for="nama_pelanggan">Nama Pelanggan :</label>
                                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="asal">Kota Asal :</label>
                                            <input type="text" class="form-control" id="asal" name="asal" placeholder="Kota">
                                        </div>
                                    </div>';
                                    break;
                                case "transaksi":
                                    echo '
                                    <div class="form-section" id="transaksiForm">
                                        <div class="form-group">
                                            <label for="id_pelanggan">ID Pelanggan :</label>
                                            <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" placeholder="99">
                                        </div>
                                        <div class="form-group">
                                            <label for="total_pembelian">Total Pembelian :</label>
                                            <input type="text" class="form-control" id="total_pembelian" name="total_pembelian" placeholder="12345678.99">
                                        </div>
                                    </div>';
                                    break;
                                default:
                                    echo "Pilihan tidak valid";
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="tambah_data">Tambah Data</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
