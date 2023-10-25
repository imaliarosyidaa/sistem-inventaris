<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<?php
    include "config.php";

if (isset($_POST['nama_barang'])==true) {
    # code...

    $nama_barang = $_POST["nama_barang"];
    $jenis = $_POST["jenis"];
    $lokasi_saatini = $_POST["lokasi_saatini"];
    $pic = $_POST["pic"];
    $nama_spek = $_POST["nama_spek"];
    $nilai = $_POST["nilai"];
    $serial_number = $_POST["serial_number"];
    $brand = $_POST["brand"];
    $keterangan = $_POST["keterangan"];

    $query = "INSERT INTO barang VALUES (NULL,'$nama_barang','$jenis','$lokasi_saatini','$pic', '$nama_spek', '$nilai','$serial_number','$brand','$keterangan')";
    $conn->query($query);

    // Mengambil ID barang yang baru saja ditambahkan
    $last_insert_id = $conn->insert_id;

    // Query untuk input riwayat lokasi
    $query_insert_riwayat_lokasi = "INSERT INTO history_perpindahan_barang VALUES (NULL,'$last_insert_id', NULL, '$lokasi_saatini', NOW(), '{$_SESSION["user_id"]}', '$keterangan')";
    $conn->query($query_insert_riwayat_lokasi);

    header("Location: index_barang.php");
    exit();
}
?>

<?php
include "config.php";

$result = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
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
        <h1>Tambah Barang</h1>
        <form method="post" action="add_barang.php">
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            
            <!-- Jenis Barang Dropdown -->
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis</label>
                <select class="form-select" id="jenis" name="jenis" required>
                    <option selected disabled>Pilih jenis barang...</option>
                    <?php
                    include "config.php";

                    $result = $conn->query("SELECT * FROM jenis_barang");
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nama_jenis"] . '</option>';
                    }
                    ?>
                </select>
            </div>
       
        
            <!-- Lokasi Saat Ini -->
            <div class="mb-3">
                <label for="lokasi_saatini" class="form-label">Lokasi Saat Ini</label>
                <select class="form-select" id="lokasi_saatini" name="lokasi_saatini" required>
                    <option selected disabled>Pilih lokasi saat ini...</option>
                    <?php
                    include "config.php";

                    $result = $conn->query("SELECT * FROM lokasi");
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nama_lokasi"] . '</option>';
                    }
                    ?>
                </select>
            </div>

           
            <div class="mb-3">
                <label for="pic" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand">
            </div>
             <div class="mb-3">
                <label for="pic" class="form-label">PIC</label>
                <input type="text" class="form-control" id="pic" name="pic">
            </div>
           


            <div class="mb-4">
                <label for="spesifikasi" class="form-label">Spesifikasi</label>
                <br>
                <br> 
                <form class="row g-3">
                <div class="mb-4">
                <div class="col-md-4">
                    <label for="" class="form-label">Nama Spek</label>
                    <input type="text" class="form-control" id="nama_spek" name="nama_spek">
                    <div class="valid-feedback">  
                    </div>
                </div>
                </div>
                <div class="mb-4">
                <div class="col-md-4">
                    <label for="validationServer02" class="form-label">Nilai</label>
                    <input type="text" class="form-control" id="nilai" name="nilai">
                    <div class="valid-feedback">
                    </div>
                </div>
                </div>
                <div class="mb-4">
              
<?php
include "config.php";

$query = "SELECT b.*, j.nama_jenis, l.nama_lokasi 
          FROM barang b
          JOIN jenis_barang j ON b.jenis = j.id
          JOIN lokasi l ON b.lokasi_saatini = l.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-light">
        <div class="container-fluid">
          
            <div class="collapse navbar-collapse" id="navbarNav">
                
            </div>
        </div>
    </nav>
  <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
            
                    <th>Nama Spek</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                          <td><?php echo $row["nama_spek"]; ?></td>
                        <td><?php echo $row["nilai"]; ?></td>
                       
                    
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
 <br><br><br><br><br><br><br>
</body>
</html>






            <div class="mb-3">
                <label for="serial_number" class="form-label">Serial Number</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <br><br><br><br><br><br><br>
</body>
</html>


