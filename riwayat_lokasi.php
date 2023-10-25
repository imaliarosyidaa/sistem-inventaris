<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT rl.*, b.nama_barang, l.nama_lokasi AS lokasi_sebelum_nama, l2.nama_lokasi AS lokasi_sesudah_nama
          FROM history_perpindahan_barang rl
          JOIN barang b ON rl.id_barang = b.id
          LEFT JOIN lokasi l ON rl.lokasi_sebelum = l.id
          LEFT JOIN lokasi l2 ON rl.lokasi_sesudah = l2.id
          ORDER BY rl.waktu_input DESC";
       
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lokasi Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style type="text/css">
        div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem Inventaris</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <?php include 'menu.php' ?>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>History Perpindahan Barang</h1>
        <table id="example" style="width: 100%" class="table">
    <!--  <form action="History_perpindahanbarang.php" method="get">
	<label>Cari :</label>
	<input type="text" name="cari">
	<input type="submit" value="Cari">
</form> -->
 
<?php 
if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
	echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Lokasi Sebelum</th>
                    <th>Lokasi Sesudah</th>
                    <th>Waktu Input</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$count</td>";
                    echo "<td>{$row['nama_barang']}</td>";
                    echo "<td>{$row['lokasi_sebelum_nama']}</td>";
                    echo "<td>{$row['lokasi_sesudah_nama']}</td>";
                    echo "<td>{$row['waktu_input']}</td>";
                    echo "<td>{$row['keterangan']}</td>";
                    echo "</tr>";
                    $count++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <td>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    new DataTable('#example', {
        scrollX: true
    });
</script>
<center>

<a href="cetak.php" class="btn btn-info">CETAK</a> </center>
</html>
