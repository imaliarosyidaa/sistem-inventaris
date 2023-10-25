<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include "config.php";

// Fungsi untuk menghindari XSS (Cross-Site Scripting)
function sanitize($data) {
    return htmlspecialchars($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama_barang = $_POST["nama_barang"];
    $jenis = $_POST["jenis"];
    $lokasi_saatini = $_POST["lokasi_saatini"];
    $pic = $_POST["pic"];
    $nama_spek = $_POST["nama_spek"];
    $nilai = $_POST["nilai"];
    $serial_number = $_POST["serial_number"];
    $brand = $_POST["brand"];
    $keterangan = $_POST["keterangan"];

    // Dapatkan informasi lokasi sebelum perubahan
    $query_lokasi_sebelum = "SELECT lokasi_saatini FROM barang WHERE id = $id";
    $result_lokasi_sebelum = $conn->query($query_lokasi_sebelum);
    $row_lokasi_sebelum = $result_lokasi_sebelum->fetch_assoc();
    $lokasi_sebelum = $row_lokasi_sebelum["lokasi_saatini"];

    $query_update = "UPDATE barang SET 
                    nama_barang = '$nama_barang', 
                    jenis = '$jenis', 
                    lokasi_saatini = '$lokasi_saatini', 
                    pic = '$pic', 
                    nama_spek = '$nama_spek',
                    nilai = '$nilai',
                    serial_number = '$serial_number', 
                    brand = '$brand', 
                    keterangan = '$keterangan' 
                    WHERE id = $id";
    $conn->query($query_update);

    // Tambahkan riwayat lokasi jika lokasi berubah
    if ($lokasi_sebelum != $lokasi_saatini) {
        $query_insert_riwayat_lokasi = "INSERT INTO history_perpindahan_barang VALUES (NULL,'$id', '$lokasi_sebelum', '$lokasi_saatini', NOW(), '{$_SESSION["user_id"]}', '$keterangan')";
        $conn->query($query_insert_riwayat_lokasi);
    }

    header("Location: index_barang.php");
    exit();
}


$id = $_GET["id"];
$result = $conn->query("SELECT * FROM barang WHERE id = $id");
$row = $result->fetch_assoc();

// Ambil data untuk dropdown jenis
$jenis_result = $conn->query("SELECT * FROM jenis_barang");

// Ambil data untuk dropdown lokasi
$lokasi_result = $conn->query("SELECT * FROM lokasi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Inventaris</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <?php include 'menu.php'; ?>
                
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>"Edit history"</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis</label>
                <select class="form-select" id="jenis" name="jenis" required>
                    <?php while ($jenis_row = $jenis_result->fetch_assoc()) { ?>
                        <option value="<?php echo $jenis_row['id']; ?>" <?php if ($jenis_row['id'] == $row['jenis']) echo 'selected'; ?>><?php echo sanitize($jenis_row['nama_jenis']); ?></option> 
                    <?php } ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="lokasi_saatini" class="form-label">Lokasi Saat Ini</label>
                <select class="form-select" id="lokasi_saatini" name="lokasi_saatini" required>
                    <?php while ($lokasi_row = $lokasi_result->fetch_assoc()) { ?>
                        <option value="<?php echo $lokasi_row['id']; ?>" <?php if ($lokasi_row['id'] == $row['lokasi_saatini']) echo 'selected'; ?>><?php echo sanitize($lokasi_row['nama_lokasi']); ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="pic" class="form-label">PIC</label>
                <input type="text" class="form-control" id="pic" name="pic" value="<?php echo $row['pic']; ?>" readonly>
            </div>
            
           
            <div class="mb-4">
                <label for="spesifikasi" class="form-label">Spesifikasi</label>
                <br>
                <br> 
                <form class="row g-3">
                <div class="mb-4">
                <div class="col-md-4">
                    <label for="" class="form-label">Nama Spek</label>
                    <input type="text" class="form-control" id="nama_spek" name="nama_spek" value="<?php echo $row['nama_spek']; ?>" readonly>
                    <div class="valid-feedback">  
                    </div>
                </div>
                </div>
                <div class="mb-4">
                <div class="col-md-4">
                    <label for="validationServer02" class="form-label">Nilai</label>
                    <input type="text" class="form-control" id="nilai" name="nilai" value="<?php echo $row['nilai']; ?>"readonly>
                    <div class="valid-feedback">
                    </div>
                </div>
                </div>
              
              
               
            
            <div class="mb-3">
                <label for="serial_number" class="form-label">Serial Number</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $row['serial_number']; ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $row['brand']; ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4"><?php echo $row['keterangan']; ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
