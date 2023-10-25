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
    <meta charset="UTF-10">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
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
        <h1>Daftar Barang</h1>
        <a href="add_barang.php" class="btn btn-info mb-5">Tambah Barang</a>
    <!--  <form action="index_barang.php" method="get">
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
        <table id="example" class="table">
        <thead>
                <tr>
                    <th>ID</th>
                    <th>NamaBarang</th>
                    <th>Jenis</th>
                    <th>Lokasi</th>
                    <th>Pic</th>
                    <th>NamaSpek</th>
                    <th>Nilai</th>
                    <th>SerialNumber</th>
                    <th>Brand</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["nama_barang"]; ?></td>
                        <td><?php echo $row["nama_jenis"]; ?></td>
                        <td><?php echo $row["nama_lokasi"]; ?></td>
                        <td><?php echo $row["pic"]; ?></td>
                        <td><?php echo $row["nama_spek"]; ?></td>
                        <td><?php echo $row["nilai"]; ?></td>
                        <td><?php echo $row["serial_number"]; ?></td>
                        <td><?php echo $row["brand"]; ?></td>
                        <td><?php echo $row["keterangan"]; ?></td>
                       
                        <td>
                          
                       <p> <a href="edit_barang.php?id=<?php echo $row["id"]; ?>" class="btn btn-info">Edit</a></p>
                        <p> <a href="edit_history.php?id=<?php echo $row["id"]; ?>" class="btn btn-info">EditHistory</a></p>
                        <a href="delete_barang.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
              

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
   <br><br><br><br><br><br><br>
    
</body>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    new DataTable('#example', {
        scrollX: true
    });
</script>

</html>
