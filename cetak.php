
<!DOCTYPE html>
<html>
<head>
	<title>CETAK </title>
</head>
<body>
 

 
	<?php 
	include 'config.php';
	?>
 
	<table border="1" style="width: 100%">
		<tr>
			<th width="1%">No</th>
                     
                    <th>Nama Barang</th>
                    <th>Lokasi Sebelum</th>
                    <th>Lokasi Sesudah</th>
                    <th>Waktu Input</th>
                    <th>Keterangan</th>
		</tr>
		<?php 
	$query = "SELECT rl.*, b.nama_barang, l.nama_lokasi AS lokasi_sebelum_nama, l2.nama_lokasi AS lokasi_sesudah_nama
    FROM history_perpindahan_barang rl
    JOIN barang b ON rl.id_barang = b.id
    LEFT JOIN lokasi l ON rl.lokasi_sebelum = l.id
    LEFT JOIN lokasi l2 ON rl.lokasi_sesudah = l2.id
    ORDER BY rl.waktu_input DESC";
 
$result = $conn->query($query);
?>

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
		</tr>
		<?php 
	
		?>
	</table>
 
	<script>
		window.print();
	</script>
 
</body>
</html>